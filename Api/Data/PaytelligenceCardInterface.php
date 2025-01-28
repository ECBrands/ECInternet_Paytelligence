<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
interface PaytelligenceCardInterface extends ExtensibleDataInterface
{
    const COLUMN_ID                    = 'entity_id';

    const COLUMN_CREATED_AT            = 'created_at';

    const COLUMN_UPDATED_AT            = 'updated_at';

    const COLUMN_CARDID                = 'CARDID';

    const COLUMN_AUDTDATE              = 'AUDTDATE';

    const COLUMN_AUDTTIME              = 'AUDTTIME';

    const COLUMN_AUDTUSER              = 'AUDTUSER';

    const COLUMN_AUDTORG               = 'AUDTORG';

    const COLUMN_MERCODE               = 'MERCODE';

    const COLUMN_SHIPTO                = 'SHIPTO';

    const COLUMN_CARDSTTE              = 'CARDSTTE';

    const COLUMN_PROFILID              = 'PROFILID';

    const COLUMN_CARDMASK              = 'CARDMASK';

    const COLUMN_CUSTOMER              = 'CUSTOMER';

    const COLUMN_CARDTYPE              = 'CARDTYPE';

    const COLUMN_CARDNAME              = 'CARDNAME';

    const COLUMN_DRIVLIC               = 'DRIVLIC';

    const COLUMN_IPADDR                = 'IPADDR';

    const COLUMN_BILADDR1              = 'BILADDR1';

    const COLUMN_BILADDR2              = 'BILADDR2';

    const COLUMN_BILCITY               = 'BILCITY';

    const COLUMN_BILPROV               = 'BILPROV';

    const COLUMN_BILCTRY               = 'BILCTRY';

    const COLUMN_BILPSTL               = 'BILPSTL';

    const COLUMN_CNTPHONE              = 'CNTPHONE';

    const COLUMN_EXPYEAR               = 'EXPYEAR';

    const COLUMN_EXPMONTH              = 'EXPMONTH';

    const COLUMN_COMMENT               = 'COMMENT';

    const COLUMN_TRNSLMT               = 'TRNSLMT';

    const COLUMN_CARDPWD               = 'CARDPWD';

    const COLUMN_DFLTCARD              = 'DFLTCARD';

    const COLUMN_AVS                   = 'AVS';

    const COLUMN_CVV                   = 'CVV';

    const COLUMN_ISSTORED              = 'ISSTORED';

    const COLUMN_EMAIL                 = 'EMAIL';

    const COLUMN_SWIPEOPT              = 'SWIPEOPT';

    const COLUMN_APPROFILEID           = 'APPROFILEID';

    const COLUMN_CCNETWORK             = 'CCNETWORK';

    const COLUMN_LAST_ORDER_ID         = 'last_order_id';

    const CARD_STATE_ACTIVE            = 1;

    const CARD_STATE_DELETED           = 2;

    const CARD_STATE_DELETED_BY_SYSTEM = 3;

    const CARD_TYPE_AMEX               = 0;

    const CARD_NAME_AMEX               = 'American Express';

    const CARD_TYPE_VISA               = 1;

    const CARD_NAME_VISA               = 'Visa';

    const CARD_TYPE_MASTERCARD         = 2;

    const CARD_NAME_MASTERCARD         = 'MasterCard';

    const CARD_TYPE_DISCOVER           = 3;

    const CARD_NAME_DISCOVER           = 'Discover';

    const CARD_NAME_UNKNOWN            = 'Unknown';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt(string $updatedAt);

    /**
     * @return int
     */
    public function getCardId();

    /**
     * @param int $cardId
     *
     * @return void
     */
    public function setCardId(int $cardId);

    /**
     * @return string
     */
    public function getAuditDate();

    /**
     * @param string $auditDate
     *
     * @return void
     */
    public function setAuditDate(string $auditDate);

    /**
     * @return string
     */
    public function getAuditTime();

    /**
     * @param string $auditTime
     *
     * @return void
     */
    public function setAuditTime(string $auditTime);

    /**
     * @return string
     */
    public function getAuditUser();

    /**
     * @param string $auditUser
     *
     * @return void
     */
    public function setAuditUser(string $auditUser);

    /**
     * @return string
     */
    public function getAuditOrganization();

    /**
     * @param string $auditOrganization
     *
     * @return void
     */
    public function setAuditOrganization(string $auditOrganization);

    /**
     * @return string
     */
    public function getMerchantCode();

    /**
     * @param string $merchantCode
     *
     * @return void
     */
    public function setMerchantCode(string $merchantCode);

    /**
     * @return string
     */
    public function getShipToLocation();

    /**
     * @param string $shipToLocation
     *
     * @return void
     */
    public function setShipToLocation(string $shipToLocation);

    /**
     * @return int
     */
    public function getCardState();

    /**
     * @param int $cardState
     *
     * @return void
     */
    public function setCardState(int $cardState);

    /**
     * @return string
     */
    public function getCreditCardProfileId();

    /**
     * @param string $creditCardProfileId
     *
     * @return void
     */
    public function setCreditCardProfileId(string $creditCardProfileId);

    /**
     * @return string
     */
    public function getCardMask();

    /**
     * @param string $cardMask
     *
     * @return void
     */
    public function setCardMask(string $cardMask);

    /**
     * @return string
     */
    public function getCustomer();

    /**
     * @param string $customer
     *
     * @return void
     */
    public function setCustomer(string $customer);

    /**
     * @return int
     */
    public function getCardType();

    /**
     * @param int $cardType
     *
     * @return void
     */
    public function setCardType(int $cardType);

    /**
     * @return string
     */
    public function getCardholdersName();

    /**
     * @param string $cardholderName
     *
     * @return void
     */
    public function setCardholdersName(string $cardholderName);

    /**
     * @return string
     */
    public function getDriversLicenseNumber();

    /**
     * @param string $driversLicenseNumber
     *
     * @return void
     */
    public function setDriversLicenseNumber(string $driversLicenseNumber);

    /**
     * @return string
     */
    public function getIpAddress();

    /**
     * @param string $ipAddress
     *
     * @return void
     */
    public function setIpAddress(string $ipAddress);

    /**
     * @return string
     */
    public function getBillToAddressLine1();

    /**
     * @param string $billToAddressLine1
     *
     * @return void
     */
    public function setBillToAddressLine1(string $billToAddressLine1);

    /**
     * @return string
     */
    public function getBillToAddressLine2();

    /**
     * @param string $billToAddressLine2
     *
     * @return void
     */
    public function setBillToAddressLine2(string $billToAddressLine2);

    /**
     * @return string
     */
    public function getBillToCity();

    /**
     * @param string $billToCity
     *
     * @return void
     */
    public function setBillToCity(string $billToCity);

    /**
     * @return string
     */
    public function getBillToProvinceState();

    /**
     * @param string $provinceState
     *
     * @return void
     */
    public function setBillToProvinceState(string $provinceState);

    /**
     * @return string
     */
    public function getBillToCountry();

    /**
     * @param string $billToCountry
     *
     * @return void
     */
    public function setBillToCountry(string $billToCountry);

    /**
     * @return string
     */
    public function getBillToZipPostalCode();

    /**
     * @param string $zipPostalCode
     *
     * @return void
     */
    public function setBillToZipPostalCode(string $zipPostalCode);

    /**
     * @return string
     */
    public function getContactPhoneNumber();

    /**
     * @param string $contactPhoneNumber
     *
     * @return void
     */
    public function setContactPhoneNumber(string $contactPhoneNumber);

    /**
     * @return int
     */
    public function getExpiryMonth();

    /**
     * @param int $expiryMonth
     *
     * @return void
     */
    public function setExpiryMonth(int $expiryMonth);

    /**
     * @return int
     */
    public function getExpiryYear();

    /**
     * @param int $expiryYear
     *
     * @return void
     */
    public function setExpiryYear(int $expiryYear);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $comment
     *
     * @return void
     */
    public function setComment(string $comment);

    /**
     * @return float
     */
    public function getTransactionLimit();

    /**
     * @param float $transactionLimit
     *
     * @return void
     */
    public function setTransactionLimit(float $transactionLimit);

    /**
     * @return string
     */
    public function getCardPassword();

    /**
     * @param string $cardPassword
     *
     * @return void
     */
    public function setCardPassword(string $cardPassword);

    /**
     * @return bool
     */
    public function getDefaultCard();

    /**
     * @param bool $defaultCard
     *
     * @return void
     */
    public function setDefaultCard(bool $defaultCard);

    /**
     * @return string
     */
    public function getAVSMessage();

    /**
     * @param string $avsMessage
     *
     * @return void
     */
    public function setAVSMessage(string $avsMessage);

    /**
     * @return string
     */
    public function getCVVMessage();

    /**
     * @param string $cvvMessage
     *
     * @return void
     */
    public function setCVVMessage(string $cvvMessage);

    /**
     * @return bool
     */
    public function getIsCardStored();

    /**
     * @param bool $isCardStored
     *
     * @return void
     */
    public function setIsCardStored(bool $isCardStored);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     *
     * @return void
     */
    public function setEmail(string $email);

    /**
     * @return bool
     */
    public function getWasCardSwiped();

    /**
     * @param bool $wasCardSwiped
     *
     * @return void
     */
    public function setWasCardSwiped(bool $wasCardSwiped);

    /**
     * @return string
     */
    public function getPaymentProfile();

    /**
     * @param string $paymentProfile
     *
     * @return void
     */
    public function setPaymentProfile(string $paymentProfile);

    /**
     * @return string
     */
    public function getCreditCardNetwork();

    /**
     * @param string $creditCardNetwork
     *
     * @return void
     */
    public function setCreditCardNetwork(string $creditCardNetwork);

    /**
     * @return int
     */
    public function getLastOrderId();

    /**
     * @param int $lastOrderId
     *
     * @return void
     */
    public function setLastOrderId(int $lastOrderId);

    /**
     * Get extension attributes
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceCardExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set extension attributes
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceCardExtensionInterface $extensionAttributes
     *
     * @return void
     */
    public function setExtensionAttributes(PaytelligenceCardExtensionInterface $extensionAttributes);

    /**
     * @return string
     */
    public function getLastFourDigits();
}
