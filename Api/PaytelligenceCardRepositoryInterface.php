<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface;
use ECInternet\Paytelligence\Api\Data\SetCardIdRequestInterface;

interface PaytelligenceCardRepositoryInterface
{
    /**
     * Save card
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface $card
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(PaytelligenceCardInterface $card);

    /**
     * Bulk save card records
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface[] $nncardArray
     *
     * @return bool[]
     */
    public function bulkSave(array $nncardArray);

    /**
     * Get card by id
     *
     * @param int $cardId
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $cardId);

    /**
     * @param int $cardId
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByCardId(int $cardId);

    /**
     * Get card by profile_id
     *
     * @param string $profileId
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface|null
     */
    public function getByProfileId(string $profileId);

    /**
     * Get list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \ECInternet\Paytelligence\Api\Data\CardSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete card
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface $card
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(PaytelligenceCardInterface $card);

    /**
     * Delete card by ID
     *
     * @param int $cardId
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $cardId);

    /**
     * @param \ECInternet\Paytelligence\Api\Data\SetCardIdRequestInterface $setCardIdRequest
     *
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function setCardId(SetCardIdRequestInterface $setCardIdRequest);
}
