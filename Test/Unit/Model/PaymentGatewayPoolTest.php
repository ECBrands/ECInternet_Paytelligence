<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Test\Unit\Model;

use ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface;
use ECInternet\Paytelligence\Logger\Logger;
use ECInternet\Paytelligence\Model\PaymentGatewayPool;
use Magento\Framework\Exception\LocalizedException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PaymentGatewayPoolTest extends TestCase
{
    /** @var Logger|MockObject */
    private $logger;

    protected function setUp(): void
    {
        $this->logger = $this->createMock(Logger::class);
    }

    private function createGatewayMock(): MockObject
    {
        return $this->createMock(PaymentGatewayInterface::class);
    }

    private function createPool(array $gateways = []): PaymentGatewayPool
    {
        return new PaymentGatewayPool($this->logger, $gateways);
    }

    // -------------------------------------------------------------------------
    // Tests: constructor validation
    // -------------------------------------------------------------------------

    public function testConstructorThrowsWhenElementDoesNotImplementInterface(): void
    {
        $this->expectException(LocalizedException::class);

        $this->createPool(['invalid' => new \stdClass()]);
    }

    public function testConstructorAcceptsEmptyGatewayArray(): void
    {
        $pool = $this->createPool();

        $this->assertSame([], $pool->getPaymentGateways());
    }

    public function testConstructorAcceptsValidGatewayImplementations(): void
    {
        $gateway = $this->createGatewayMock();

        $pool = $this->createPool(['braintree' => $gateway]);

        $this->assertCount(1, $pool->getPaymentGateways());
    }

    // -------------------------------------------------------------------------
    // Tests: getPaymentGateways()
    // -------------------------------------------------------------------------

    public function testGetPaymentGatewaysReturnsAllRegisteredGateways(): void
    {
        $gateway1 = $this->createGatewayMock();
        $gateway2 = $this->createGatewayMock();

        $pool = $this->createPool([
            'gateway_a' => $gateway1,
            'gateway_b' => $gateway2,
        ]);

        $result = $pool->getPaymentGateways();

        $this->assertCount(2, $result);
        $this->assertSame($gateway1, $result['gateway_a']);
        $this->assertSame($gateway2, $result['gateway_b']);
    }

    // -------------------------------------------------------------------------
    // Tests: getPaymentGateway()
    // -------------------------------------------------------------------------

    public function testGetPaymentGatewayReturnsCorrectGatewayByName(): void
    {
        $gateway = $this->createGatewayMock();

        $pool   = $this->createPool(['braintree' => $gateway]);
        $result = $pool->getPaymentGateway('braintree');

        $this->assertSame($gateway, $result);
    }

    public function testGetPaymentGatewayThrowsWhenNameNotFound(): void
    {
        $this->expectException(LocalizedException::class);

        $pool = $this->createPool();
        $pool->getPaymentGateway('nonexistent');
    }
}
