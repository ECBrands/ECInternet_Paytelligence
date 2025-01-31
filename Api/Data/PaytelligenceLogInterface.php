<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api\Data;

interface PaytelligenceLogInterface
{
    public const COLUMN_ID              = 'entity_id';

    public const COLUMN_CREATED_AT      = 'created_at';

    public const COLUMN_UPDATED_AT      = 'updated_at';

    public const COLUMN_ORDER_NUMBER    = 'order_number';

    public const COLUMN_PAYMENT_GATEWAY = 'payment_gateway';

    public const COLUMN_AREA_CODE       = 'area_code';

    public const COLUMN_LOG_TYPE        = 'log_type';

    public const COLUMN_VALUE           = 'value';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @return string
     */
    public function getOrderNumber();

    /**
     * @param string $orderNumber
     */
    public function setOrderNumber(string $orderNumber);

    /**
     * @return string
     */
    public function getPaymentGateway();

    /**
     * @param string $paymentGateway
     *
     * @return void
     */
    public function setPaymentGateway(string $paymentGateway);

    /**
     * @return string
     */
    public function getAreaCode();

    /**
     * @param string $areaCode
     *
     * @return void
     */
    public function setAreaCode(string $areaCode);

    /**
     * @return string
     */
    public function getLogType();

    /**
     * @param string $logType
     *
     * @return void
     */
    public function setLogType(string $logType);

    /**
     * @return string
     */
    public function getValue();

    /**
     * @param mixed $value
     *
     * @return void
     */
    public function setValue($value);
}
