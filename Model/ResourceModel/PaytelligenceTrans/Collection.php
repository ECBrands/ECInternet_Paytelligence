<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * PaytelligenceTrans ResourceModel Collection
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
    protected $_eventPrefix = 'paytelligence_paytelligence_trans_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'paytelligence_trans_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        $this->_init(
            \ECInternet\Paytelligence\Model\PaytelligenceTrans::class,
            \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans::class
        );
    }
}
