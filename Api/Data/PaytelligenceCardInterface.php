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
    public const COLUMN_ID                    = 'entity_id';

    public const COLUMN_CREATED_AT            = 'created_at';

    public const COLUMN_UPDATED_AT            = 'updated_at';

    public const COLUMN_CARDID                = 'CARDID';

    public const COLUMN_AUDTDATE              = 'AUDTDATE';

    public const COLUMN_AUDTTIME              = 'AUDTTIME';

    public const COLUMN_AUDTUSER              = 'AUDTUSER';

    public const COLUMN_AUDTORG               = 'AUDTORG';

    public const COLUMN_MERCODE               = 'MERCODE';

    public const COLUMN_SHIPTO                = 'SHIPTO';

    public const COLUMN_CARDSTTE              = 'CARDSTTE';

    public const COLUMN_PROFILID              = 'PROFILID';

    public const COLUMN_CARDMASK              = 'CARDMASK';

    public const COLUMN_CUSTOMER              = 'CUSTOMER';

    public const COLUMN_CARDTYPE              = 'CARDTYPE';

    public const COLUMN_CARDNAME              = 'CARDNAME';

    public const COLUMN_DRIVLIC               = 'DRIVLIC';

    public const COLUMN_IPADDR                = 'IPADDR';

    public const COLUMN_BILADDR1              = 'BILADDR1';

    public const COLUMN_BILADDR2              = 'BILADDR2';

    public const COLUMN_BILCITY               = 'BILCITY';

    public const COLUMN_BILPROV               = 'BILPROV';

    public const COLUMN_BILCTRY               = 'BILCTRY';

    public const COLUMN_BILPSTL               = 'BILPSTL';

    public const COLUMN_CNTPHONE              = 'CNTPHONE';

    public const COLUMN_EXPYEAR               = 'EXPYEAR';

    public const COLUMN_EXPMONTH              = 'EXPMONTH';

    public const COLUMN_COMMENT               = 'COMMENT';

    public const COLUMN_TRNSLMT               = 'TRNSLMT';

    public const COLUMN_CARDPWD               = 'CARDPWD';

    public const COLUMN_DFLTCARD              = 'DFLTCARD';

    public const COLUMN_AVS                   = 'AVS';

    public const COLUMN_CVV                   = 'CVV';

    public const COLUMN_ISSTORED              = 'ISSTORED';

    public const COLUMN_EMAIL                 = 'EMAIL';

    public const COLUMN_SWIPEOPT              = 'SWIPEOPT';

    public const COLUMN_APPROFILEID           = 'APPROFILEID';

    public const COLUMN_CCNETWORK             = 'CCNETWORK';

    public const COLUMN_LAST_ORDER_ID         = 'last_order_id';

    public const CARD_STATE_ACTIVE            = 1;

    public const CARD_STATE_DELETED           = 2;

    public const CARD_STATE_DELETED_BY_SYSTEM = 3;

    public const CARD_TYPE_AMEX               = 0;

    public const CARD_NAME_AMEX               = 'American Express';

    public const CARD_TYPE_VISA               = 1;

    public const CARD_NAME_VISA               = 'Visa';

    public const CARD_TYPE_MASTERCARD         = 2;

    public const CARD_NAME_MASTERCARD         = 'MasterCard';

    public const CARD_TYPE_DISCOVER           = 3;

    public const CARD_NAME_DISCOVER           = 'Discover';

    public const CARD_NAME_UNKNOWN            = 'Unknown';

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
