<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TransactionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceTransInterface[]
     */
    public function getItems();

    /**
     * Set items
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceTransInterface[] $items
     *
     * @return void
     */
    public function setItems(array $items);
}
