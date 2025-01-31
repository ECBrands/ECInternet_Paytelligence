<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * PaytelligenceCard ResourceModel Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'paytelligence_paytelligence_card_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'paytelligence_card_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $this->_init(
            \ECInternet\Paytelligence\Model\PaytelligenceCard::class,
            \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard::class
        );
    }
}
