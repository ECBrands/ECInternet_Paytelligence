<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use ECInternet\Paytelligence\Api\Data\PaytelligenceTransInterface;
use ECInternet\Paytelligence\Api\Data\TransactionSearchResultsInterfaceFactory;
use ECInternet\Paytelligence\Api\PaytelligenceTransRepositoryInterface;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans as TransactionResource;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans\CollectionFactory as TransactionCollectionFactory;
use Exception;

/**
 * Paytelligence transaction repository
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PaytelligenceTransRepository implements PaytelligenceTransRepositoryInterface
{
    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var \ECInternet\Paytelligence\Api\Data\TransactionSearchResultsInterfaceFactory
     */
    private $transactionSearchResultsFactory;

    /**
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans
     */
    private $resourceModel;

    /**
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans\CollectionFactory
     */
    private $transactionCollectionFactory;

    /**
     * PaytelligenceTransRepository constructor.
     *
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface                 $collectionProcessor
     * @param \ECInternet\Paytelligence\Api\Data\TransactionSearchResultsInterfaceFactory        $transactionSearchResultsInterfaceFactory
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans                   $resourceModel
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans\CollectionFactory $transactionCollectionFactory
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        TransactionSearchResultsInterfaceFactory $transactionSearchResultsInterfaceFactory,
        TransactionResource $resourceModel,
        TransactionCollectionFactory $transactionCollectionFactory
    ) {
        $this->collectionProcessor             = $collectionProcessor;
        $this->transactionSearchResultsFactory = $transactionSearchResultsInterfaceFactory;
        $this->resourceModel                   = $resourceModel;
        $this->transactionCollectionFactory    = $transactionCollectionFactory;
    }

    public function save(
        PaytelligenceTransInterface $transaction
    ) {
        try {
            $this->resourceModel->save($transaction);
        } catch (Exception $e) {
            if ($transaction->getId()) {
                throw new CouldNotSaveException(
                    __('Unable to save Paytelligence transaction with ID %1. Error: %2', [$transaction->getId(), $e->getMessage()])
                );
            }

            throw new CouldNotSaveException(__('Unable to save Paytelligence transaction. Error: %1', $e->getMessage()));
        }

        return $transaction;
    }

    public function getById(
        int $transactionId
    ) {
        /** @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans\Collection $collection */
        $collection = $this->transactionCollectionFactory->create()
            ->addFieldToFilter(PaytelligenceTrans::COLUMN_ID, ['eq' => $transactionId]);

        $collectionCount = $collection->getSize();
        if ($collectionCount === 1) {
            $transaction = $collection->getFirstItem();
            if ($transaction instanceof PaytelligenceTransInterface) {
                return $transaction;
            }
        } elseif ($collectionCount === 0) {
            throw new NoSuchEntityException(__('Unable to find Paytelligence transaction with ID "%1"', $transactionId));
        } else {
            throw new LocalizedException(__('Found multiple Paytelligence transactions with ID "%1"', $transactionId));
        }

        return null;
    }

    public function getByTransactionId(
        string $gatewayTransactionId
    ) {
        /** @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans\Collection $collection */
        $collection = $this->transactionCollectionFactory->create()
            ->addFieldToFilter(PaytelligenceTrans::COLUMN_GWTRNSID, ['eq' => $gatewayTransactionId])
            ->addFieldToFilter(PaytelligenceTrans::COLUMN_PARENTID, ['eq' => '']);

        $collectionCount = $collection->getSize();
        if ($collectionCount === 1) {
            $transaction = $collection->getFirstItem();
            if ($transaction instanceof PaytelligenceTransInterface) {
                return $transaction;
            }
        } elseif ($collectionCount === 0) {
            throw new NoSuchEntityException(__('Unable to find Paytelligence transaction with GWTRNSID "%1"', $gatewayTransactionId));
        } else {
            throw new LocalizedException(__('Found multiple Paytelligence transactions with GWTRANSID "%1"', $gatewayTransactionId));
        }

        return null;
    }

    public function getList(
        SearchCriteriaInterface $searchCriteria
    ) {
        /** @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans\Collection $collection */
        $collection = $this->transactionCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var \ECInternet\Paytelligence\Api\Data\TransactionSearchResultsInterface $searchResults */
        $searchResults = $this->transactionSearchResultsFactory->create();

        /** @noinspection PhpExpressionResultUnusedInspection */
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());

        /** @noinspection PhpParamsInspection */
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}
