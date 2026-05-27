<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Block\Card;

use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Payment\Model\CcConfig;
use ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface;
use ECInternet\Paytelligence\Model\Config;
use Psr\Log\LoggerInterface;

/**
 * New Card Block
 */
class NewAction extends Template
{
    /**
     * @var \Magento\Directory\Helper\Data
     */
    private $directoryHelper;

    /**
     * @var \Magento\Payment\Model\CcConfig
     */
    private $ccConfig;

    /**
     * @var \ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface
     */
    private $paymentGatewayPool;

    /**
     * @var \ECInternet\Paytelligence\Model\Config
     */
    private $config;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * NewAction constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context          $context
     * @param \Magento\Directory\Helper\Data                            $directoryHelper
     * @param \Magento\Payment\Model\CcConfig                           $ccConfig
     * @param \ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface $paymentGatewayPool
     * @param \ECInternet\Paytelligence\Model\Config                    $config
     * @param \Psr\Log\LoggerInterface                                  $logger
     * @param array                                                     $data
     */
    public function __construct(
        Context $context,
        DirectoryHelper $directoryHelper,
        CcConfig $ccConfig,
        PaymentGatewayPoolInterface $paymentGatewayPool,
        Config $config,
        LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->directoryHelper    = $directoryHelper;
        $this->ccConfig           = $ccConfig;
        $this->paymentGatewayPool = $paymentGatewayPool;
        $this->config             = $config;
        $this->logger             = $logger;
    }

    public function getCcMonths()
    {
        return $this->ccConfig->getCcMonths();
    }

    public function getCcYears()
    {
        return $this->ccConfig->getCcYears();
    }

    /**
     * Retrieve regions data json
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getRegionJson()
    {
        return $this->directoryHelper->getRegionJson();
    }

    public function getAllowedCountries()
    {
        $this->log('getAllowedCountries()');

        if ($paymentGatewayCode = $this->config->getAddCardPaymentGateway()) {
            if ($paymentGateway = $this->getPaymentGateway($paymentGatewayCode)) {
                return $paymentGateway->getAllowedCountries();
            } else {
                $this->log('getAllowedCountries() - Could not find payment gateway ' . $paymentGatewayCode);
            }
        } else {
            $this->log('getAllowedCountries() - Could not find payment gateway setting value');
        }

        return [];
    }

    private function getPaymentGateway(string $paymentGatewayCode)
    {
        try {
            return $this->paymentGatewayPool->getPaymentGateway($paymentGatewayCode);
        } catch (LocalizedException $e) {
            $this->log('getPaymentGateway()', ['exception' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Write to extension log
     *
     * @param string $message
     * @param array  $extra
     */
    private function log(string $message, array $extra = [])
    {
        $this->logger->info('[ECInternet_Paytelligence] Block/Card/NewAction - ' . $message, $extra);
    }
}
