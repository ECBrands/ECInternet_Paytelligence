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
use ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface;
use ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface;
use ECInternet\Paytelligence\Helper\Data;
use ECInternet\Paytelligence\Logger\Logger;
use Exception;

/**
 * Card Edit Block
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Edit extends Template
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
     * @var \ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface
     */
    private $cardRepository;

    /**
     * @var \ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface
     */
    private $paymentGatewayPool;

    /**
     * @var \ECInternet\Paytelligence\Helper\Data
     */
    private $helper;

    /**
     * @var \ECInternet\Paytelligence\Logger\Logger
     */
    private $logger;

    /**
     * Edit constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context                   $context
     * @param \Magento\Directory\Helper\Data                                     $directoryHelper
     * @param \Magento\Payment\Model\CcConfig                                    $ccConfig
     * @param \ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface $cardRepository
     * @param \ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface          $paymentGatewayPool
     * @param \ECInternet\Paytelligence\Helper\Data                              $helper
     * @param \ECInternet\Paytelligence\Logger\Logger                            $logger
     * @param array                                                              $data
     */
    public function __construct(
        Context $context,
        DirectoryHelper $directoryHelper,
        CcConfig $ccConfig,
        PaytelligenceCardRepositoryInterface $cardRepository,
        PaymentGatewayPoolInterface $paymentGatewayPool,
        Data $helper,
        Logger $logger,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->directoryHelper    = $directoryHelper;
        $this->ccConfig           = $ccConfig;
        $this->cardRepository     = $cardRepository;
        $this->paymentGatewayPool = $paymentGatewayPool;
        $this->helper             = $helper;
        $this->logger             = $logger;
    }

    /**
     * Get Paytelligence card
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface|null
     */
    public function getCard()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                return $this->cardRepository->getById((int)$id);
            } catch (Exception $e) {
                $this->log('getCard()', ['exception' => $e->getMessage()]);
            }
        }

        return null;
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

        /** @var \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface $card */
        if ($card = $this->getCard()) {
            if ($creditCardNetwork = $card->getCreditCardNetwork()) {
                if ($paymentGateway = $this->getPaymentGateway($creditCardNetwork)) {
                    return $paymentGateway->getAllowedCountries();
                }
            }
        }

        return [];
    }

    /**
     * @param string $country
     * @param string $region
     *
     * @return int|null
     */
    public function getRegionId(string $country, string $region)
    {
        return $this->helper->getRegionId($country, $region);
    }

    private function getPaymentGateway(string $paymentMethodCode)
    {
        $this->log('getPaymentGateway()', ['paymentMethodCode' => $paymentMethodCode]);

        try {
            return $this->paymentGatewayPool->getPaymentGateway($paymentMethodCode);
        } catch (LocalizedException $e) {
            $this->log('getPaymentGateway()', ['exception' => $e->getMessage()]);
        }

        return null;
    }

    private function log(string $message, array $extra = [])
    {
        $this->logger->info('Block/Card/Edit - ' . $message, $extra);
    }
}
