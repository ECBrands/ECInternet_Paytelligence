<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\Exception\LocalizedException;
use ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface;
use ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface;
use ECInternet\Paytelligence\Logger\Logger;

class PaymentGatewayPool implements PaymentGatewayPoolInterface
{
    /**
     * @var \ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface[]
     */
    protected $paymentGateways;

    /**
     * @var \ECInternet\Paytelligence\Logger\Logger
     */
    protected $logger;

    /**
     * PaymentGatewayPool constructor.
     *
     * @param \ECInternet\Paytelligence\Logger\Logger $logger
     * @param array                                   $paymentGateways
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        Logger $logger,
        array $paymentGateways = []
    ) {
        $this->logger = $logger;

        foreach ($paymentGateways as $paymentGatewayName => $paymentGateway) {
            if (!$paymentGateway instanceof PaymentGatewayInterface) {
                throw new LocalizedException(
                    __(
                        'Payment Gateway %1 must be of type ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface',
                        $paymentGatewayName
                    )
                );
            }
        }

        $this->paymentGateways = $paymentGateways;
    }

    /**
     * @inheritDoc
     */
    public function getPaymentGateways()
    {
        $this->log('getPaymentGateways()');

        return $this->paymentGateways;
    }

    public function getPaymentGateway($name)
    {
        $this->log('getPaymentGateway()', ['name' => $name]);

        if (array_key_exists($name, $this->paymentGateways)) {
            return $this->paymentGateways[$name];
        }

        throw new LocalizedException(__('Payment Gateway %1 not found', $name));
    }

    private function log(string $message, array $extra = [])
    {
        $this->logger->info('Model/PaymentGatewayPool - ' . $message, $extra);
    }
}
