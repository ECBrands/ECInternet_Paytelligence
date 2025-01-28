<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api\Data;

use Exception;

interface PaymentGatewayInterface
{
    /**
     * @return string
     */
    public function getCode();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return \Magento\Payment\Gateway\Config\Config
     */
    public function getConfig();

    /**
     * @return bool
     */
    public function allowCreate();

    /**
     * @return bool
     */
    public function allowEdit();

    /**
     * @return bool
     */
    public function allowDelete();

    /**
     * @return array
     */
    public function getAllowedCountries();

    /**
     * @param array $request
     *
     * @return array
     * @throws Exception
     */
    public function addVaultCard(array $request);

    /**
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface $card
     *
     * @return bool
     * @throws Exception
     */
    public function updateVaultCard(PaytelligenceCardInterface $card);

    public function saveCard(array $requestData, array $response);
}
