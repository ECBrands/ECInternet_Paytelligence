<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api;

interface PaymentGatewayPoolInterface
{
    /**
     * @return \ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface[]
     */
    public function getPaymentGateways();

    /**
     * @param string $name
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @noinspection PhpMissingParamTypeInspection
     */
    public function getPaymentGateway($name);
}
