<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\Api\SearchResults;
use ECInternet\Paytelligence\Api\Data\TransactionSearchResultsInterface;

class TransactionSearchResults extends SearchResults implements TransactionSearchResultsInterface
{
}
