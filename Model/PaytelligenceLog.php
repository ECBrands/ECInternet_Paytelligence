<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use ECInternet\Paytelligence\Api\Data\PaytelligenceLogInterface;

/**
 * PaytelligenceTrans model
 */
class PaytelligenceLog extends AbstractModel implements IdentityInterface, PaytelligenceLogInterface
{
    private const CACHE_TAG = 'paytelligence_log';

    protected $_cacheTag = self::CACHE_TAG;

    protected $_eventPrefix = 'paytelligence_paytelligence_log';

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $_jsonSerializer;

    /**
     * PaytelligenceLog constructor.
     *
     * @param \Magento\Framework\Model\Context                             $context
     * @param \Magento\Framework\Registry                                  $registry
     * @param \Magento\Framework\Serialize\Serializer\Json                 $jsonSerializer
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null           $resourceCollection
     * @param array                                                        $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        JsonSerializer $jsonSerializer,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

        $this->_jsonSerializer = $jsonSerializer;
    }

    protected function _construct()
    {
        $this->_init(ResourceModel\PaytelligenceLog::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->getData(self::COLUMN_ID);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::COLUMN_CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::COLUMN_UPDATED_AT);
    }

    public function getOrderNumber()
    {
        return $this->getData(self::COLUMN_ORDER_NUMBER);
    }

    public function setOrderNumber($orderNumber)
    {
        $this->setData(self::COLUMN_ORDER_NUMBER, $orderNumber);
    }

    public function getPaymentGateway()
    {
        return $this->getData(self::COLUMN_PAYMENT_GATEWAY);
    }

    public function setPaymentGateway($paymentGateway)
    {
        $this->setData(self::COLUMN_PAYMENT_GATEWAY, $paymentGateway);
    }

    public function getAreaCode()
    {
        return $this->getData(self::COLUMN_AREA_CODE);
    }

    public function setAreaCode($areaCode)
    {
        $this->setData(self::COLUMN_AREA_CODE, $areaCode);
    }

    public function getLogType()
    {
        return $this->getData(self::COLUMN_LOG_TYPE);
    }

    public function setLogType($logType)
    {
        $this->setData(self::COLUMN_LOG_TYPE, $logType);
    }

    public function getValue()
    {
        return $this->getData(self::COLUMN_VALUE);
    }

    public function setValue($value)
    {
        if (is_array($value)) {
            unset($value['ccnum']);

            $value = $this->_jsonSerializer->serialize($value);
        }

        $this->setData(self::COLUMN_VALUE, $value);
    }
}
