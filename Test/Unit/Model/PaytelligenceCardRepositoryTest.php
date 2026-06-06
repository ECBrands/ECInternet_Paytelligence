<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Test\Unit\Model {

    use ECInternet\Paytelligence\Api\Data\CardSearchResultsInterfaceFactory;
    use ECInternet\Paytelligence\Logger\Logger;
    use ECInternet\Paytelligence\Model\PaytelligenceCard;
    use ECInternet\Paytelligence\Model\PaytelligenceCardRepository;
    use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard as CardResource;
    use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\Collection as CardCollection;
    use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory as CardCollectionFactory;
    use Exception;
    use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
    use PHPUnit\Framework\MockObject\MockObject;
    use PHPUnit\Framework\TestCase;

    /**
     * Unit tests for PaytelligenceCardRepository::bulkSave()
     */
    class PaytelligenceCardRepositoryTest extends TestCase
    {
        /** @var CardResource|MockObject */
        private $resourceModel;

        /** @var CardCollectionFactory|MockObject */
        private $cardCollectionFactory;

        /** @var PaytelligenceCardRepository */
        private $repository;

        protected function setUp(): void
        {
            $this->resourceModel         = $this->createMock(CardResource::class);
            $this->cardCollectionFactory = $this->createMock(CardCollectionFactory::class);

            $this->repository = new PaytelligenceCardRepository(
                $this->createMock(CollectionProcessorInterface::class),
                $this->createMock(CardSearchResultsInterfaceFactory::class),
                $this->createMock(Logger::class),
                $this->resourceModel,
                $this->cardCollectionFactory
            );
        }

        // -------------------------------------------------------------------------
        // Helpers
        // -------------------------------------------------------------------------

        /**
         * Create a mock of PaytelligenceCardInterface.
         *
         * getData() is the only method that exists on the concrete model but is
         * absent from the interface (it comes from AbstractModel/DataObject).
         * All interface methods — including setId() — are mocked automatically.
         *
         * @return MockObject
         */
        private function createCardMock(): MockObject
        {
            return $this->getMockBuilder(PaytelligenceCard::class)
                ->disableOriginalConstructor()
                ->getMock();
        }

        /**
         * Build a CardCollection mock pre-configured for a single-result lookup.
         *
         * @param int             $size
         * @param MockObject|null $firstItem
         *
         * @return MockObject
         */
        private function createCollectionMock(int $size, MockObject $firstItem = null): MockObject
        {
            $collection = $this->createMock(CardCollection::class);
            $collection->method('addFieldToFilter')->willReturnSelf();
            $collection->method('getSelect')->willReturn(null);
            $collection->method('getSize')->willReturn($size);

            if ($firstItem !== null) {
                $collection->method('getFirstItem')->willReturn($firstItem);
            }

            return $collection;
        }

        // -------------------------------------------------------------------------
        // Tests: ID included in bulk-save
        // -------------------------------------------------------------------------

        /**
         * When a card already has an entity ID the repository skips the existence
         * check and persists the card directly via the resource model.
         *
         * Expected result: [true]
         */
        public function testBulkSaveWithIdIncludedSavesDirectly(): void
        {
            $card = $this->createCardMock();
            $card->method('getId')->willReturn(42);

            // No collection lookup should occur because the ID is already present.
            $this->cardCollectionFactory->expects($this->never())->method('create');
            $this->resourceModel->expects($this->once())->method('save')->with($card);

            // Make method call
            $results = $this->repository->bulkSave([$card]);

            $this->assertSame([true], $results);
        }

        /**
         * Multiple cards that all carry an entity ID are each persisted once.
         *
         * Expected result: [true, true]
         */
        public function testBulkSaveMultipleCardsWithIdIncluded(): void
        {
            $card1 = $this->createCardMock();
            $card1->method('getId')->willReturn(10);
            $card1->method('getData')->willReturn([]);

            $card2 = $this->createCardMock();
            $card2->method('getId')->willReturn(20);
            $card2->method('getData')->willReturn([]);

            $this->cardCollectionFactory->expects($this->never())->method('create');
            $this->resourceModel->expects($this->exactly(2))->method('save');

            // Make method call
            $results = $this->repository->bulkSave([$card1, $card2]);

            $this->assertSame([true, true], $results);
        }

        /**
         * When the resource model throws during a save (card with ID included), the
         * exception is caught and the corresponding slot in the results array is false.
         *
         * Expected result: [false]
         */
        public function testBulkSaveWithIdIncludedResourceModelExceptionReturnsFalse(): void
        {
            $card = $this->createCardMock();
            $card->method('getId')->willReturn(7);

            $this->resourceModel
                ->method('save')
                ->willThrowException(new Exception('DB error'));

            // Make method call
            $results = $this->repository->bulkSave([$card]);

            $this->assertSame([false], $results);
        }

        // -------------------------------------------------------------------------
        // Tests: ID NOT included in bulk-save
        // -------------------------------------------------------------------------

        /**
         * When a card has no entity ID and provides no profile ID or card ID,
         * doesRecordExist() returns false immediately.  The card is saved as a
         * new record without any collection lookup.
         *
         * Expected result: [true]
         */
        public function testBulkSaveWithoutIdAndNoLookupIdentifiersSavesAsNew(): void
        {
            $card = $this->createCardMock();
            $card->method('getId')->willReturn(null);
            $card->method('getCreditCardProfileId')->willReturn('');
            $card->method('getCardId')->willReturn(0);
            $card->method('getData')->willReturn([]);

            // doesRecordExist() exits early — no collection should be created.
            $this->cardCollectionFactory->expects($this->never())->method('create');

            $this->resourceModel->expects($this->once())->method('save')->with($card);

            $results = $this->repository->bulkSave([$card]);

            $this->assertSame([true], $results);
        }

        /**
         * When a card has no entity ID but its profile ID matches an existing
         * record, the repository:
         *   1. Calls getByProfileId() inside doesRecordExist() — finds a match.
         *   2. Calls getByCardId() to retrieve the existing entity ID.
         *   3. Sets that entity ID on the incoming card via setId().
         *   4. Persists the card (update, not insert).
         *
         * Expected result: [true]
         */
        public function testBulkSaveWithoutIdExistingRecordFoundByProfileIdSetsIdAndSaves(): void
        {
            $existingEntityId = 99;
            $profileId        = 'PROFILE-ABC';
            $cardId           = 789;

            // Existing record returned by both collection lookups.
            $existingCard = $this->createCardMock();
            $existingCard->method('getId')->willReturn($existingEntityId);

            // Incoming card — no entity ID, but has a profile ID and card ID.
            $card = $this->createCardMock();
            $card->method('getId')->willReturn(null);
            $card->method('getCreditCardProfileId')->willReturn($profileId);
            $card->method('getCardId')->willReturn($cardId);

            // First collection:  getByProfileId() inside doesRecordExist().
            // Second collection: getByCardId() after doesRecordExist() returns true
            $this->cardCollectionFactory
                ->expects($this->exactly(2))
                ->method('create')
                ->willReturnOnConsecutiveCalls(
                    $this->createCollectionMock(1, $existingCard),
                    $this->createCollectionMock(1, $existingCard)
                );

            // The incoming card must receive the entity ID from the existing record.
            $card->expects($this->once())->method('setId')->with($existingEntityId);

            $this->resourceModel->expects($this->once())->method('save')->with($card);

            $results = $this->repository->bulkSave([$card]);

            $this->assertSame([true], $results);
        }

        /**
         * When a card has no entity ID and carries a card ID, doesRecordExist()
         * calls getByCardId() to check for an existing record.  If no record is
         * found, getByCardId() throws a NoSuchEntityException.  Because this
         * exception occurs outside save()'s internal try/catch it propagates to
         * bulkSave(), which catches it and records a failure.
         *
         * Expected result: [false]
         */
        public function testBulkSaveWithoutIdCardIdNotFoundReturnsFalse(): void
        {
            $card = $this->createCardMock();
            $card->method('getId')->willReturn(null);
            $card->method('getCreditCardProfileId')->willReturn('');
            $card->method('getCardId')->willReturn(555);
            $card->method('getData')->willReturn([]);

            // Collection returns 0 results — getByCardId() will throw NoSuchEntityException.
            $emptyCollection = $this->createMock(CardCollection::class);
            $emptyCollection->method('addFieldToFilter')->willReturnSelf();
            $emptyCollection->method('getSelect')->willReturn(null);
            $emptyCollection->method('getSize')->willReturn(0);

            $this->cardCollectionFactory
                ->expects($this->once())
                ->method('create')
                ->willReturn($emptyCollection);

            // resourceModel->save() must not be reached.
            $this->resourceModel->expects($this->never())->method('save');

            $results = $this->repository->bulkSave([$card]);

            $this->assertSame([false], $results);
        }

        /**
         * Regression test for the getId()-typed-as-int bug.
         *
         * When getId() was declared as `: int`, a new model returned null which PHP
         * silently cast to 0.  The old `empty($card->getId())` check treated 0 as
         * "no ID" and triggered the record-lookup branch.  If no match was found the
         * card was passed to the resource model with getId() === 0 (not null), causing
         * the resource model to run UPDATE WHERE entity_id = 0 — zero rows affected,
         * silent data loss.
         *
         * The fix uses `$card->getId() === null` so a non-null value of 0 (however
         * unlikely in production) is treated as "has an ID" and skips the lookup,
         * passing directly to the resource model.
         *
         * Expected result: [true]  (no lookup; save is attempted)
         */
        public function testBulkSaveWithNonNullZeroIdSkipsLookupAndDelegatesToResourceModel(): void
        {
            $card = $this->createCardMock();
            $card->method('getId')->willReturn(0);   // non-null but falsy — old empty() would have entered lookup
            $card->method('getData')->willReturn([]);

            // === null check means the lookup branch is skipped entirely.
            $this->cardCollectionFactory->expects($this->never())->method('create');

            $this->resourceModel->expects($this->once())->method('save')->with($card);

            $results = $this->repository->bulkSave([$card]);

            $this->assertSame([true], $results);
        }

        // -------------------------------------------------------------------------
        // Tests: Mixed results and edge cases
        // -------------------------------------------------------------------------

        /**
         * In a batch where the first card (with ID) saves successfully and the
         * second card (with ID) causes a resource model exception, bulkSave()
         * continues processing and returns one result entry per card.
         *
         * Expected result: [true, false]
         */
        public function testBulkSaveMixedSuccessAndFailureReturnsMixedResults(): void
        {
            $cardSuccess = $this->createCardMock();
            $cardSuccess->method('getId')->willReturn(1);
            $cardSuccess->method('getData')->willReturn([]);

            $cardFailure = $this->createCardMock();
            $cardFailure->method('getId')->willReturn(2);
            $cardFailure->method('getData')->willReturn([]);

            $this->resourceModel
                ->expects($this->exactly(2))
                ->method('save')
                ->willReturnCallback(function ($card) use ($cardFailure) {
                    if ($card === $cardFailure) {
                        throw new Exception('Simulated failure');
                    }
                });

            $results = $this->repository->bulkSave([$cardSuccess, $cardFailure]);

            $this->assertSame([true, false], $results);
        }

        /**
         * Calling bulkSave() with an empty array returns an empty results array
         * and makes no calls to the resource model.
         */
        public function testBulkSaveEmptyArrayReturnsEmptyResults(): void
        {
            $this->resourceModel->expects($this->never())->method('save');

            $results = $this->repository->bulkSave([]);

            $this->assertSame([], $results);
        }
    }
}

// ---------------------------------------------------------------------------
// Stub factory classes for environments where Magento code generation has not
// yet been run (i.e. before bin/magento setup:di:compile).  Guards prevent
// conflicts when the generated classes ARE present.
// ---------------------------------------------------------------------------

namespace ECInternet\Paytelligence\Api\Data {
    if (!class_exists(CardSearchResultsInterfaceFactory::class)) {
        class CardSearchResultsInterfaceFactory
        {
            public function create() { return null; }
        }
    }
}

namespace ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard {
    if (!class_exists(CollectionFactory::class)) {
        class CollectionFactory
        {
            public function create() { return null; }
        }
    }
}
