<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * PaytelligenceLog ResourceModel Collection
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
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
    protected $_eventPrefix = 'paytelligence_paytelligence_log_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'paytelligence_log_collection';

    /**
     * Define resource model
     *
     * @return void
     *
     * @noinspection PhpFullyQualifiedNameUsageInspection
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init(
            \ECInternet\Paytelligence\Model\PaytelligenceLog::class,
            \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceLog::class
        );
    }
}
