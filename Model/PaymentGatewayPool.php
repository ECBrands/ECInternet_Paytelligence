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
use Psr\Log\LoggerInterface;

class PaymentGatewayPool implements PaymentGatewayPoolInterface
{
    /**
     * @var \ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface[]
     */
    protected $paymentGateways;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * PaymentGatewayPool constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $paymentGateways
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        LoggerInterface $logger,
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

    /**
     * Write to extension log
     *
     * @param string $message
     * @param array  $extra
     */
    private function log(string $message, array $extra = [])
    {
        $this->logger->info('[ECInternet_Paytelligence] Model/PaymentGatewayPool - ' . $message, $extra);
    }
}
