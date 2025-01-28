<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use ECInternet\Paytelligence\Api\Data\PaytelligenceTransInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
interface PaytelligenceTransRepositoryInterface
{
    /**
     * Save transaction
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceTransInterface $transaction
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceTransInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(PaytelligenceTransInterface $transaction);

    /**
     * Get transaction by id
     *
     * @param int $transactionId
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceTransInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $transactionId);

    /**
     * Get transaction by gateway transaction id
     *
     * @param string $gatewayTransactionId
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceTransInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByTransactionId(string $gatewayTransactionId);

    /**
     * Get list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \ECInternet\Paytelligence\Api\Data\TransactionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
