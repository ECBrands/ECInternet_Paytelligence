<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface;

class PaymentGateway implements OptionSourceInterface
{
    /**
     * @var \ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface
     */
    private $paymentGatewayPool;

    /**
     * @param \ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface $paymentGatewayPool
     */
    public function __construct(
        PaymentGatewayPoolInterface $paymentGatewayPool
    ) {
        $this->paymentGatewayPool = $paymentGatewayPool;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];

        foreach ($this->getOptions() as $value => $label) {
            $result[] = [
                'value' => $value,
                'label' => $label,
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        $result = [];

        /** @var \ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface $paymentGateway */
        foreach ($this->paymentGatewayPool->getPaymentGateways() as $paymentGateway) {
            $result[$paymentGateway->getCode()] = $paymentGateway->getName();
        }

        return $result;
    }
}
