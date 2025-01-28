<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Helper;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Directory\Model\Region;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory as RegionCollectionFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Model\Order\Payment;
use ECInternet\Paytelligence\Helper\Customer as CustomerHelper;
use ECInternet\Paytelligence\Model\PaytelligenceCard;
use ECInternet\Paytelligence\Model\PaytelligenceTrans;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory as CardCollectionFactory;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans\CollectionFactory as TransCollectionFactory;
use ECInternet\Paytelligence\Logger\Logger;

/**
 * Helper
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Data extends AbstractHelper
{
    const CONFIG_PATH_ENABLED                 = 'paytelligence/general/enable';

    const CONFIG_PATH_ADD_CARD_PAYMENT_METHOD = 'paytelligence/card_maintenance/new_card_payment_method';

    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    private $_regionCollectionFactory;

    /**
     * @var \ECInternet\Paytelligence\Helper\Customer
     */
    private $customerHelper;

    /**
     * @var \ECInternet\Paytelligence\Logger\Logger
     */
    private $logger;

    /**
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory
     */
    private $_paytelligenceCardCollectionFactory;

    /**
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans\CollectionFactory
     */
    private $_paytelligenceTransCollectionFactory;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context                                              $context
     * @param \Magento\Directory\Model\ResourceModel\Region\CollectionFactory                    $regionCollectionFactory
     * @param \ECInternet\Paytelligence\Helper\Customer                                          $customerHelper
     * @param \ECInternet\Paytelligence\Logger\Logger                                            $logger
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory  $cardCollectionFactory
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceTrans\CollectionFactory $transCollectionFactory
     */
    public function __construct(
        Context $context,
        RegionCollectionFactory $regionCollectionFactory,
        CustomerHelper $customerHelper,
        Logger $logger,
        CardCollectionFactory $cardCollectionFactory,
        TransCollectionFactory $transCollectionFactory
    ) {
        parent::__construct($context);

        $this->_regionCollectionFactory             = $regionCollectionFactory;
        $this->customerHelper                       = $customerHelper;
        $this->logger                               = $logger;
        $this->_paytelligenceCardCollectionFactory  = $cardCollectionFactory;
        $this->_paytelligenceTransCollectionFactory = $transCollectionFactory;
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

    /**
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     *
     * @return \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\Collection|null
     */
    public function getStoredCardCollectionForCustomer(
        CustomerInterface $customer
    ) {
        $this->log('getStoredCardCollectionForCustomer()');

        $customerNumbers = $this->getCustomerNumbers($customer);
        $this->log('getStoredCardCollectionForCustomer()', ['customerNumbers' => $customerNumbers]);

        if ($collection = $this->getStoredCardCollectionByCustomerNumbers($customerNumbers)) {
            $this->log('getStoredCardCollectionForCustomer()', [
                'query' => $collection->getSelect()->__toString(),
                'count' => $collection->getSize()
            ]);

            return $collection;
        }

        return null;
    }

    /**
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     *
     * @return string[]
     */
    public function getCustomerNumbers(CustomerInterface $customer)
    {
        return $this->customerHelper->getCustomerNumbers($customer);
    }

    /**
     * Gets stored Paytelligence cards billing address for the currently-logged-in customer.
     *
     * @return array
     */
    public function getStoredCardsBillingAddresses()
    {
        $storedCardAddresses = [];

        if ($storedCards = $this->getStoredCardsForLoggedInCustomer()) {
            foreach ($storedCards as $storedCard) {
                /** @var \ECInternet\Paytelligence\Model\PaytelligenceCard $storedCard */
                $id                                     = $storedCard->getCreditCardProfileId();
                $storedCardAddresses[$id]['company']    = $storedCard->getCardholdersName();
                $storedCardAddresses[$id]['fname']      = $storedCard->getCardholdersName();
                $storedCardAddresses[$id]['bill_addr1'] = $storedCard->getBillToAddressLine1();
                $storedCardAddresses[$id]['bill_addr2'] = $storedCard->getBillToAddressLine2();
                $storedCardAddresses[$id]['city']       = $storedCard->getBillToCity();
                $storedCardAddresses[$id]['state']      = $this->getRegionId($storedCard->getBillToCountry(), $storedCard->getBillToProvinceState());
                $storedCardAddresses[$id]['region']     = $storedCard->getBillToProvinceState();
                $storedCardAddresses[$id]['postalcode'] = $storedCard->getBillToZipPostalCode();
                $storedCardAddresses[$id]['country']    = $storedCard->getBillToCountry();
                $storedCardAddresses[$id]['phone']      = $storedCard->getContactPhoneNumber();
            }
        }

        return $storedCardAddresses;
    }

    /**
     * Get stored cards for the currently-logged-in customer
     *
     * @return \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\Collection|null
     */
    public function getStoredCardsForLoggedInCustomer()
    {
        /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
        if ($customer = $this->customerHelper->getCurrentCustomer()) {
            return $this->getStoredCardCollectionForCustomer($customer);
        }

        return null;
    }

    public function hasPreviousTransactions(CustomerInterface $customer, string $cardMask)
    {
        $customerNumbers = $this->getCustomerNumbers($customer);
        $this->log('hasPreviousTransactions()', ['customerNumbers' => $customerNumbers]);

        $collection = $this->_paytelligenceTransCollectionFactory->create()
            ->addFieldToFilter(PaytelligenceTrans::COLUMN_CUSTOMER, ['in' => implode(',', $customerNumbers)])
            ->addFieldToFilter(PaytelligenceTrans::COLUMN_CARDNUM, ['eq' => $cardMask]);

        return $collection->getSize() > 0;
    }

    /**
     * Throw exception if card already in vault.
     *
     * @param \Magento\Sales\Model\Order\Payment           $payment
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function confirmNewCard(Payment $payment, CustomerInterface $customer)
    {
        $this->log('confirmNewCard()', [
            'paymentAdditionalInformation' => $payment->getAdditionalInformation()
        ]);

        // Only check if a previous card is not being used
        if ($payment->getAdditionalInformation('cc_saved_id') === null) {
            $last4digits = substr($payment->getData('cc_number'), -4);
            $expMonth    = $payment->getAdditionalInformation('cc_exp_month');
            $expYear     = $payment->getAdditionalInformation('cc_exp_year');

            $this->log('confirmNewCard()', [
                PaytelligenceCard::COLUMN_CARDMASK => $last4digits,
                PaytelligenceCard::COLUMN_EXPMONTH => $expMonth,
                PaytelligenceCard::COLUMN_EXPYEAR  => $expYear
            ]);

            $customerNumbers = $this->getCustomerNumbers($customer);
            $this->log('confirmNewCard()', ['customerNumbers' => $customerNumbers]);

            if (!is_numeric($expMonth)) {
                throw new LocalizedException(
                    __('Invalid expiration month. Please enter a valid expiration month.')
                );
            }

            if (!is_numeric($expYear)) {
                throw new LocalizedException(
                    __('Invalid expiration year. Please enter a valid expiration year.')
                );
            }

            if (!$this->isNewCard($last4digits, $customerNumbers, (int)$expMonth, (int)$expYear)) {
                throw new LocalizedException(
                    __('This credit card already exists. Please enter a different credit card number.')
                );
            }
        }
    }

    /**
     * Is this a new card?
     *
     * @param string $last4digits
     * @param array  $customerNumbers
     * @param int    $expirationMonth
     * @param int    $expirationYear
     * @param int    $cardState
     * @param int    $isStored
     *
     * @return bool
     */
    public function isNewCard(
        string $last4digits,
        array $customerNumbers,
        int $expirationMonth,
        int $expirationYear,
        int $cardState = 1,
        int $isStored = 1
    ) {
        $this->log('isNewCard()', [
            'cardState'       => $cardState,
            'isStored'        => $isStored,
            'last4digits'     => $last4digits,
            'customerNumbers' => $customerNumbers,
            'expirationMonth' => $expirationMonth,
            'expirationYear'  => $expirationYear
        ]);

        $cardCollection = $this->_paytelligenceCardCollectionFactory->create()
            ->addFieldToFilter(PaytelligenceCard::COLUMN_CARDSTTE, ['eq' => $cardState])
            ->addFieldToFilter(PaytelligenceCard::COLUMN_ISSTORED, ['eq' => $isStored])
            ->addFieldToFilter(PaytelligenceCard::COLUMN_CARDMASK, ['like' => '%' . $last4digits])
            ->addFieldToFilter(PaytelligenceCard::COLUMN_CUSTOMER, ['in' => implode(',', $customerNumbers)])
            ->addFieldToFilter(PaytelligenceCard::COLUMN_EXPMONTH, ['eq' => $expirationMonth])
            ->addFieldToFilter(PaytelligenceCard::COLUMN_EXPYEAR,  ['eq' => $expirationYear]);

        $this->log('isNewCard()', ['query' => $cardCollection->getSelect()]);

        return $cardCollection->getSize() === 0;
    }

    /**
     * Lookup region_code by country and region_id
     *
     * @param string $country
     * @param int    $regionId
     *
     * @return string
     */
    public function getRegionCode(string $country, int $regionId)
    {
        $this->log('getRegionCode()', ['country' => $country, 'regionId' => $regionId]);

        /** @var \Magento\Directory\Model\ResourceModel\Region\Collection $regionCollection */
        $regionCollection = $this->_regionCollectionFactory->create()
            ->addCountryFilter($country)
            ->addFieldToFilter('main_table.region_id', $regionId);

        if ($regionCollection->getSize() === 1) {
            $region = $regionCollection->getFirstItem();
            if ($region instanceof Region) {
                return $region->getCode();
            }
        }

        return '';
    }

    /**
     * Lookup region_id by country and region_code
     *
     * @param string $country
     * @param string $regionCode
     *
     * @return int|null
     */
    public function getRegionId(string $country, string $regionCode)
    {
        $this->log('getRegionId()', ['country' => $country, 'regionCode' => $regionCode]);

        if (!empty($country) && !empty($regionCode)) {
            /** @var \Magento\Directory\Model\ResourceModel\Region\Collection $regionCollection */
            $regionCollection = $this->_regionCollectionFactory->create()
                ->addCountryFilter($country)
                ->addRegionCodeFilter($regionCode);

            if ($regionCollection->getSize() === 1) {
                /** @var \Magento\Directory\Model\Region $region */
                $region = $regionCollection->getFirstItem();

                return (int)$region->getId();
            }
        }

        return null;
    }

    /**
     * Retrieve Card records for array of CUSTOMER values
     *
     * @param string[] $customerNumbers
     *
     * @return \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\Collection|null
     */
    private function getStoredCardCollectionByCustomerNumbers(array $customerNumbers)
    {
        $this->log('getStoredCardCollectionByCustomerNumbers()', ['customerNumbers' => $customerNumbers]);

        if (count($customerNumbers) > 0) {
            return $this->_paytelligenceCardCollectionFactory->create()
                ->addFieldToFilter(PaytelligenceCard::COLUMN_CARDSTTE, ['eq' => 1])
                ->addFieldToFilter(PaytelligenceCard::COLUMN_ISSTORED, ['eq' => 1])
                ->addFieldToFilter(PaytelligenceCard::COLUMN_CUSTOMER, ['in' => implode(',', $customerNumbers)]);
        }

        return null;
    }

    /**
     * Write to extension log
     *
     * @param string $message
     * @param array  $extra
     *
     * @return void
     */
    private function log(string $message, array $extra = [])
    {
        $this->logger->info('Helper/Data - ' . $message, $extra);
    }
}
