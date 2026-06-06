<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Test\Unit\Model;

use ECInternet\Paytelligence\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    private const CONFIG_PATH_ENABLED          = 'paytelligence/general/enable';
    private const CONFIG_PATH_ADD_CARD_GATEWAY = 'paytelligence/card_maintenance/new_card_payment_method';

    /** @var ScopeConfigInterface|MockObject */
    private $scopeConfig;

    /** @var Config */
    private $config;

    protected function setUp(): void
    {
        $this->scopeConfig = $this->createMock(ScopeConfigInterface::class);
        $this->config      = new Config($this->scopeConfig);
    }

    // -------------------------------------------------------------------------
    // Tests: isModuleEnabled()
    // -------------------------------------------------------------------------

    public function testIsModuleEnabledReturnsTrueWhenFlagIsSet(): void
    {
        $this->scopeConfig
            ->method('isSetFlag')
            ->with(self::CONFIG_PATH_ENABLED)
            ->willReturn(true);

        $this->assertTrue($this->config->isModuleEnabled());
    }

    public function testIsModuleEnabledReturnsFalseWhenFlagIsNotSet(): void
    {
        $this->scopeConfig
            ->method('isSetFlag')
            ->with(self::CONFIG_PATH_ENABLED)
            ->willReturn(false);

        $this->assertFalse($this->config->isModuleEnabled());
    }

    // -------------------------------------------------------------------------
    // Tests: getAddCardPaymentGateway()
    // -------------------------------------------------------------------------

    public function testGetAddCardPaymentGatewayReturnsConfiguredValue(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(self::CONFIG_PATH_ADD_CARD_GATEWAY)
            ->willReturn('braintree');

        $this->assertSame('braintree', $this->config->getAddCardPaymentGateway());
    }

    public function testGetAddCardPaymentGatewayReturnsEmptyStringWhenNotConfigured(): void
    {
        $this->scopeConfig
            ->method('getValue')
            ->with(self::CONFIG_PATH_ADD_CARD_GATEWAY)
            ->willReturn(null);

        $this->assertSame('', $this->config->getAddCardPaymentGateway());
    }
}
