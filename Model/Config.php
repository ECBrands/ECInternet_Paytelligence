<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private const CONFIG_PATH_ENABLED                 = 'paytelligence/general/enable';

    private const CONFIG_PATH_ADD_CARD_PAYMENT_METHOD = 'paytelligence/card_maintenance/new_card_payment_method';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Is module enabled?
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED);
    }

    /**
     * @return string
     */
    public function getAddCardPaymentGateway()
    {
        return (string)$this->scopeConfig->getValue(self::CONFIG_PATH_ADD_CARD_PAYMENT_METHOD);
    }
}
