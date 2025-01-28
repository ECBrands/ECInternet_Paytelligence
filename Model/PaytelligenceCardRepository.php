<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use ECInternet\Paytelligence\Api\Data\CardSearchResultsInterfaceFactory;
use ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface;
use ECInternet\Paytelligence\Api\Data\SetCardIdRequestInterface;
use ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface;
use ECInternet\Paytelligence\Logger\Logger;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard as CardResource;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory as CardCollectionFactory;
use Exception;

/**
 * Paytelligence card repository
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class PaytelligenceCardRepository implements PaytelligenceCardRepositoryInterface
{
    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var \ECInternet\Paytelligence\Api\Data\CardSearchResultsInterfaceFactory
     */
    private $cardSearchResultsFactory;

    /**
     * @var \ECInternet\Paytelligence\Logger\Logger
     */
    private $logger;

    /**
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard
     */
    private $resourceModel;

    /**
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory
     */
    private $cardCollectionFactory;

    /**
     * PaytelligenceCardRepository constructor.
     *
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface                $collectionProcessor
     * @param \ECInternet\Paytelligence\Api\Data\CardSearchResultsInterfaceFactory              $cardSearchResultsInterfaceFactory
     * @param \ECInternet\Paytelligence\Logger\Logger                                           $logger
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard                   $resourceModel
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory $cardCollectionFactory
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        CardSearchResultsInterfaceFactory $cardSearchResultsInterfaceFactory,
        Logger $logger,
        CardResource $resourceModel,
        CardCollectionFactory $cardCollectionFactory
    ) {
        $this->collectionProcessor      = $collectionProcessor;
        $this->cardSearchResultsFactory = $cardSearchResultsInterfaceFactory;
        $this->logger                   = $logger;
        $this->resourceModel            = $resourceModel;
        $this->cardCollectionFactory    = $cardCollectionFactory;
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        PaytelligenceCardInterface $card
    ) {
        $this->log('save()', ['paytelligenceCard' => $card->getData()]);

        $this->validate($card);

        // If this record doesn't have an id, attempt to look one up
        if (empty($card->getId())) {
            // If we find existing, grab the ID and set on incoming record
            if ($this->doesRecordExist($card)) {
                /** @var \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface $model */
                $model = $this->getByCardId($card->getCardId());
                $this->log('save()', ['model' => $model->getData()]);

                $card->setId($model->getId());
            }
        }

        try {
            $this->resourceModel->save($card);
        } catch (Exception $e) {
            $this->log('save()', [
                'class'     => get_class($e),
                'exception' => $e->getMessage(),
                'trace'     => $e->getTraceAsString()
            ]);

            if ($card->getId()) {
                throw new CouldNotSaveException(
                    __('Unable to save Paytelligence card with ID %1. Error: %2', [$card->getId(), $e->getMessage()])
                );
            }

            throw new CouldNotSaveException(
                __('Unable to save Paytelligence card. Error: %1', $e->getMessage())
            );
        }

        return $card;
    }

    public function bulkSave(
        array $nncardArray
    ) {
        $this->log('bulkSave()', ['count' => count($nncardArray)]);

        $results = [];

        foreach ($nncardArray as $nncard) {
            $this->log('bulkSave()', ['nncard' => $nncard->getData()]);

            try {
                $this->save($nncard);
                $results[] = true;
            } catch (Exception $e) {
                $this->log('bulkSave()', ['exception' => $e->getMessage()]);
                $results[] = false;
            }
        }

        return $results;
    }

    public function getById(
        int $cardId
    ) {
        $this->log('getById()', ['cardId' => $cardId]);

        /** @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\Collection $collection */
        $collection = $this->cardCollectionFactory->create()
            ->addFieldToFilter(PaytelligenceCard::COLUMN_ID, ['eq' => $cardId]);

        $collectionCount = $collection->getSize();
        $this->log('getById()', [
            'select'          => $collection->getSelect(),
            'collectionCount' => $collectionCount
        ]);

        if ($collectionCount === 1) {
            $card = $collection->getFirstItem();
            if ($card instanceof PaytelligenceCardInterface) {
                return $card;
            }
        } elseif ($collectionCount === 0) {
            throw new NoSuchEntityException(__('Unable to find Paytelligence card with ID "%1"', $cardId));
        } else {
            throw new LocalizedException(__('Found multiple Paytelligence cards with ID "%1"', $cardId));
        }

        return null;
    }

    public function getByCardId(
        int $cardId
    ) {
        $this->log('getByCardId()', ['cardId' => $cardId]);

        /** @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\Collection $collection */
        $collection = $this->cardCollectionFactory->create()
            ->addFieldToFilter(PaytelligenceCard::COLUMN_CARDID, ['eq' => $cardId]);

        $collectionCount = $collection->getSize();
        $this->log('getByCardId()', [
            'select'          => $collection->getSelect(),
            'collectionCount' => $collectionCount
        ]);

        if ($collectionCount === 1) {
            $card = $collection->getFirstItem();
            if ($card instanceof PaytelligenceCardInterface) {
                return $card;
            }
        } elseif ($collectionCount === 0) {
            throw new NoSuchEntityException(__('Unable to find Paytelligence card with ID "%1"', $cardId));
        } else {
            throw new LocalizedException(__('Found multiple Paytelligence cards with ID "%1"', $cardId));
        }

        return null;
    }

    public function getByProfileId(
        string $profileId
    ) {
        $collection = $this->cardCollectionFactory->create()
            ->addFieldToFilter(PaytelligenceCard::COLUMN_PROFILID, $profileId);

        $collectionCount = $collection->getSize();
        $this->log('getByProfileId()', ['collectionCount' => $collectionCount]);

        if ($collectionCount === 1) {
            $card = $collection->getFirstItem();
            if ($card instanceof PaytelligenceCardInterface) {
                return $card;
            }
        }

        return null;
    }

    public function getList(
        SearchCriteriaInterface $searchCriteria
    ) {
        /** @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\Collection $collection */
        $collection = $this->cardCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var \ECInternet\Paytelligence\Api\Data\CardSearchResultsInterface $searchResults */
        $searchResults = $this->cardSearchResultsFactory->create();

        /** @noinspection PhpExpressionResultUnusedInspection */
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());

        /** @noinspection PhpParamsInspection */
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    public function delete(
        PaytelligenceCardInterface $card
    ) {
        try {
            $this->resourceModel->delete($card);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(
                __('Unable to delete Paytelligence card with ID %1.  Error: %2', [$card->getId(), $e->getMessage()])
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $cardId)
    {
        if ($card = $this->getByCardId($cardId)) {
            return $this->delete($card);
        }

        return false;
    }

    public function setCardId(
        SetCardIdRequestInterface $setCardIdRequest
    ) {
        $this->log('setCardId()', ['setCardId' => $setCardIdRequest->getData()]);

        $id = $setCardIdRequest->getId();
        $this->log('setCardId()', ['id' => $id]);

        if (is_numeric($id)) {
            if ($card = $this->getById((int)$id)) {
                $card->setCardId($setCardIdRequest->getCardId());

                try {
                    $this->save($card);
                } catch (Exception $e) {
                    $this->log('setCardId()', ['execption' => $e->getMessage()]);
                }
            }
        }
    }

    /**
     * Validate NNCARD record
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface $card
     *
     * @return void
     */
    protected function validate(
        PaytelligenceCardInterface $card
    ) {
        //if (empty($card->getCreditCardProfileId())) {
            //throw new CouldNotSaveException(__('PROFILID not set'));
        //}

        //if (empty($card->getCustomer())) {
            //throw new CouldNotSaveException(__('CUSTOMER not set'));
        //}
    }

    /**
     * Does NNCARD record exist?
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface $card
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function doesRecordExist(
        PaytelligenceCardInterface $card
    ) {
        $this->log('doesRecordExist()', ['card' => $card->getData()]);

        if ($profileId = $card->getCreditCardProfileId()) {
            return ($this->getByProfileId($profileId) !== null);
        }

        $cardId = $card->getCardId();
        if (!empty($cardId)) {
            return ($this->getByCardId($cardId) !== null);
        }

        // Unfortunately we can't tell.
        // We may need to query the DB by a certain combo, such as CUSTOMER / CARDTYPE / CARDNUM
        return false;
    }

    /**
     * Write to extension log
     *
     * @param string $message
     * @param array  $extra
     *
     * @return void
     */
    private function log(string $message, array $extra = [])
    {
        $this->logger->info('Model/PaytelligenceCardRepository - ' . $message, $extra);
    }
}
