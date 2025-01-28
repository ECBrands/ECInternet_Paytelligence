<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime;
use ECInternet\Paytelligence\Api\Data\PaytelligenceCardExtensionInterface;
use ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface;

/**
 * PaytelligenceCard data model
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class PaytelligenceCard extends AbstractExtensibleModel implements IdentityInterface, PaytelligenceCardInterface
{
    const CACHE_TAG = 'paytelligence_card';

    protected $_cacheTag = self::CACHE_TAG;

    protected $_eventPrefix = 'paytelligence_paytelligence_card';

    protected $_eventObject = 'paytelligence_card';

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    private $dateTime;

    /**
     * PaytelligenceCard constructor.
     *
     * @param \Magento\Framework\Model\Context                             $context
     * @param \Magento\Framework\Registry                                  $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory            $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory                 $customAttributeFactory
     * @param \Magento\Framework\Stdlib\DateTime                           $dateTime
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null           $resourceCollection
     * @param array                                                        $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        DateTime $dateTime,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->dateTime = $dateTime;

        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init(ResourceModel\PaytelligenceCard::class);
    }

    public function beforeSave()
    {
        // Always update (we can use this to verify syncs are running)
        $this->setUpdatedAt($this->dateTime->formatDate(true));

        return parent::beforeSave();
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->getData(self::COLUMN_ID);
    }

    public function getCreatedAt()
    {
        return (string)$this->getData(self::COLUMN_CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return (string)$this->getData(self::COLUMN_UPDATED_AT);
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->setData(self::COLUMN_UPDATED_AT, $updatedAt);
    }

    public function getCardId()
    {
        return (int)$this->getData(self::COLUMN_CARDID);
    }

    public function setCardId(int $cardId)
    {
        $this->setData(self::COLUMN_CARDID, $cardId);
    }

    public function getAuditDate()
    {
        return (string)$this->getData(self::COLUMN_AUDTDATE);
    }

    public function setAuditDate(string $auditDate)
    {
        $this->setData(self::COLUMN_AUDTDATE, $auditDate);
    }

    public function getAuditTime()
    {
        return (string)$this->getData(self::COLUMN_AUDTTIME);
    }

    public function setAuditTime(string $auditTime)
    {
        $this->setData(self::COLUMN_AUDTTIME, $auditTime);
    }

    public function getAuditUser()
    {
        return (string)$this->getData(self::COLUMN_AUDTUSER);
    }

    public function setAuditUser(string $auditUser)
    {
        $this->setData(self::COLUMN_AUDTUSER, $auditUser);
    }

    public function getAuditOrganization()
    {
        return (string)$this->getData(self::COLUMN_AUDTORG);
    }

    public function setAuditOrganization(string $auditOrganization)
    {
        $this->setData(self::COLUMN_AUDTORG, $auditOrganization);
    }

    public function getMerchantCode()
    {
        return (string)$this->getData(self::COLUMN_MERCODE);
    }

    public function setMerchantCode(string $merchantCode)
    {
        $this->setData(self::COLUMN_MERCODE, $merchantCode);
    }

    public function getShipToLocation()
    {
        return (string)$this->getData(self::COLUMN_SHIPTO);
    }

    public function setShipToLocation(string $shipToLocation)
    {
        $this->setData(self::COLUMN_SHIPTO, $shipToLocation);
    }

    public function getCardState()
    {
        return (int)$this->getData(self::COLUMN_CARDSTTE);
    }

    public function setCardState(int $cardState)
    {
        $this->setData(self::COLUMN_CARDSTTE, $cardState);
    }

    public function getCreditCardProfileId()
    {
        return (string)$this->getData(self::COLUMN_PROFILID);
    }

    public function setCreditCardProfileId(string $creditCardProfileId)
    {
        $this->setData(self::COLUMN_PROFILID, $creditCardProfileId);
    }

    public function getCardMask()
    {
        return (string)$this->getData(self::COLUMN_CARDMASK);
    }

    public function setCardMask(string $cardMask)
    {
        $this->setData(self::COLUMN_CARDMASK, $cardMask);
    }

    public function getCustomer()
    {
        return (string)$this->getData(self::COLUMN_CUSTOMER);
    }

    public function setCustomer(string $customer)
    {
        $this->setData(self::COLUMN_CUSTOMER, $customer);
    }

    public function getCardType()
    {
        return (int)$this->getData(self::COLUMN_CARDTYPE);
    }

    public function setCardType(int $cardType)
    {
        $this->setData(self::COLUMN_CARDTYPE, $cardType);
    }

    public function getCardholdersName()
    {
        return (string)$this->getData(self::COLUMN_CARDNAME);
    }

    public function setCardholdersName(string $cardholderName)
    {
        $this->setData(self::COLUMN_CARDNAME, $cardholderName);
    }

    public function getDriversLicenseNumber()
    {
        return (string)$this->getData(self::COLUMN_DRIVLIC);
    }

    public function setDriversLicenseNumber(string $driversLicenseNumber)
    {
        $this->setData(self::COLUMN_DRIVLIC, $driversLicenseNumber);
    }

    public function getIpAddress()
    {
        return (string)$this->getData(self::COLUMN_IPADDR);
    }

    public function setIpAddress(string $ipAddress)
    {
        $this->setData(self::COLUMN_IPADDR, $ipAddress);
    }

    public function getBillToAddressLine1()
    {
        return (string)$this->getData(self::COLUMN_BILADDR1);
    }

    public function setBillToAddressLine1(string $billToAddressLine1)
    {
        $this->setData(self::COLUMN_BILADDR1, $billToAddressLine1);
    }

    public function getBillToAddressLine2()
    {
        return (string)$this->getData(self::COLUMN_BILADDR2);
    }

    public function setBillToAddressLine2(string $billToAddressLine2)
    {
        $this->setData(self::COLUMN_BILADDR2, $billToAddressLine2);
    }

    public function getBillToCity()
    {
        return (string)$this->getData(self::COLUMN_BILCITY);
    }

    public function setBillToCity(string $billToCity)
    {
        $this->setData(self::COLUMN_BILCITY, $billToCity);
    }

    public function getBillToProvinceState()
    {
        return (string)$this->getData(self::COLUMN_BILPROV);
    }

    public function setBillToProvinceState(string $provinceState)
    {
        $this->setData(self::COLUMN_BILPROV, $provinceState);
    }

    public function getBillToCountry()
    {
        return (string)$this->getData(self::COLUMN_BILCTRY);
    }

    public function setBillToCountry(string $billToCountry)
    {
        $this->setData(self::COLUMN_BILCTRY, $billToCountry);
    }

    public function getBillToZipPostalCode()
    {
        return (string)$this->getData(self::COLUMN_BILPSTL);
    }

    public function setBillToZipPostalCode(string $zipPostalCode)
    {
        $this->setData(self::COLUMN_BILPSTL, $zipPostalCode);
    }

    public function getContactPhoneNumber()
    {
        return (string)$this->getData(self::COLUMN_CNTPHONE);
    }

    public function setContactPhoneNumber(string $contactPhoneNumber)
    {
        $this->setData(self::COLUMN_CNTPHONE, $contactPhoneNumber);
    }

    public function getExpiryYear()
    {
        return (int)$this->getData(self::COLUMN_EXPYEAR);
    }

    public function setExpiryYear(int $expiryYear)
    {
        $this->setData(self::COLUMN_EXPYEAR, $expiryYear);
    }

    public function getExpiryMonth()
    {
        return (int)$this->getData(self::COLUMN_EXPMONTH);
    }

    public function setExpiryMonth(int $expiryMonth)
    {
        $this->setData(self::COLUMN_EXPMONTH, $expiryMonth);
    }

    public function getComment()
    {
        return (string)$this->getData(self::COLUMN_COMMENT);
    }

    public function setComment(string $comment)
    {
        $this->setData(self::COLUMN_COMMENT, $comment);
    }

    public function getTransactionLimit()
    {
        return (float)$this->getData(self::COLUMN_TRNSLMT);
    }

    public function setTransactionLimit(float $transactionLimit)
    {
        $this->setData(self::COLUMN_TRNSLMT, $transactionLimit);
    }

    public function getCardPassword()
    {
        return (string)$this->getData(self::COLUMN_CARDPWD);
    }

    public function setCardPassword(string $cardPassword)
    {
        $this->setData(self::COLUMN_CARDPWD, $cardPassword);
    }

    public function getDefaultCard()
    {
        return (bool)$this->getData(self::COLUMN_DFLTCARD);
    }

    public function setDefaultCard(bool $defaultCard)
    {
        $this->setData(self::COLUMN_DFLTCARD, $defaultCard);
    }

    public function getAVSMessage()
    {
        return (string)$this->getData(self::COLUMN_AVS);
    }

    public function setAVSMessage(string $avsMessage)
    {
        $this->setData(self::COLUMN_AVS, $avsMessage);
    }

    public function getCVVMessage()
    {
        return (string)$this->getData(self::COLUMN_CVV);
    }

    public function setCVVMessage(string $cvvMessage)
    {
        $this->setData(self::COLUMN_CVV, $cvvMessage);
    }

    public function getIsCardStored()
    {
        return (bool)$this->getData(self::COLUMN_ISSTORED);
    }

    public function setIsCardStored(bool $isCardStored)
    {
        $this->setData(self::COLUMN_ISSTORED, $isCardStored);
    }

    public function getEmail()
    {
        return (string)$this->getData(self::COLUMN_EMAIL);
    }

    public function setEmail(string $email)
    {
        $this->setData(self::COLUMN_EMAIL, $email);
    }

    public function getWasCardSwiped()
    {
        return (bool)$this->getData(self::COLUMN_SWIPEOPT);
    }

    public function setWasCardSwiped(bool $wasCardSwiped)
    {
        $this->setData(self::COLUMN_SWIPEOPT, $wasCardSwiped);
    }

    public function getPaymentProfile()
    {
        return (string)$this->getData(self::COLUMN_APPROFILEID);
    }

    public function setPaymentProfile(string $paymentProfile)
    {
        $this->setData(self::COLUMN_APPROFILEID, $paymentProfile);
    }

    public function getCreditCardNetwork()
    {
        return (string)$this->getData(self::COLUMN_CCNETWORK);
    }

    public function setCreditCardNetwork(string $creditCardNetwork)
    {
        $this->setData(self::COLUMN_CCNETWORK, $creditCardNetwork);
    }

    public function getLastOrderId()
    {
        return (int)$this->getData(self::COLUMN_LAST_ORDER_ID);
    }

    public function setLastOrderId(int $lastOrderId)
    {
        $this->setData(self::COLUMN_LAST_ORDER_ID, $lastOrderId);
    }

    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    public function setExtensionAttributes(PaytelligenceCardExtensionInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * @return string
     */
    public function getOptionDisplay()
    {
        return $this->getCardMask() . ' (' . $this->getCardholdersName() . ')';
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getLastFourDigits()
    {
        $cardMask = $this->getCardMask();

        if (strlen($cardMask) < 4) {
            throw new LocalizedException(__('Card Mask is less than 4 characters'));
        }

        return substr($cardMask, -4);
    }

    /**
     * Get expiration date in MM/YY format
     *
     * @return string
     */
    public function getExpirationDisplay()
    {
        return $this->getExpiryMonth() . '/' . $this->getExpiryYear();
    }

    /**
     * @return string
     */
    public function getCardTypeName()
    {
        $cardType = $this->getCardType();
        if ($cardType == self::CARD_TYPE_AMEX) {
            return self::CARD_NAME_AMEX;
        } elseif ($cardType == self::CARD_TYPE_VISA) {
            return self::CARD_NAME_VISA;
        } elseif ($cardType == self::CARD_TYPE_MASTERCARD) {
            return self::CARD_NAME_MASTERCARD;
        } elseif ($cardType == self::CARD_TYPE_DISCOVER) {
            return self::CARD_NAME_DISCOVER;
        } else {
            return self::CARD_NAME_UNKNOWN;
        }
    }

    /**
     * @param array $data
     */
    public function buildFromArray(array $data)
    {
        if (isset($data[self::COLUMN_CARDID])) {
            $this->setCardId($data[self::COLUMN_CARDID]);
        }

        if (isset($data[self::COLUMN_MERCODE])) {
            $this->setMerchantCode($data[self::COLUMN_MERCODE]);
        }

        if (isset($data[self::COLUMN_CARDSTTE])) {
            $this->setCardState($data[self::COLUMN_CARDSTTE]);
        }

        if (isset($data[self::COLUMN_PROFILID])) {
            $this->setCreditCardProfileId($data[self::COLUMN_PROFILID]);
        }

        if (isset($data[self::COLUMN_CARDMASK])) {
            $this->setCardMask($data[self::COLUMN_CARDMASK]);
        }

        if (isset($data[self::COLUMN_CUSTOMER])) {
            $this->setCustomer($data[self::COLUMN_CUSTOMER]);
        }

        if (isset($data[self::COLUMN_CARDTYPE])) {
            $this->setCardType($data[self::COLUMN_CARDTYPE]);
        }

        if (isset($data[self::COLUMN_CARDNAME])) {
            $this->setCardholdersName($data[self::COLUMN_CARDNAME]);
        }

        if (isset($data[self::COLUMN_IPADDR])) {
            $this->setIpAddress($data[self::COLUMN_IPADDR]);
        }

        if (isset($data[self::COLUMN_BILADDR1])) {
            $this->setBillToAddressLine1($data[self::COLUMN_BILADDR1]);
        }

        if (isset($data[self::COLUMN_BILADDR2])) {
            $this->setBillToAddressLine2($data[self::COLUMN_BILADDR2]);
        }

        if (isset($data[self::COLUMN_BILCITY])) {
            $this->setBillToCity($data[self::COLUMN_BILCITY]);
        }

        if (isset($data[self::COLUMN_BILPROV])) {
            $this->setBillToProvinceState($data[self::COLUMN_BILPROV]);
        }

        if (isset($data[self::COLUMN_BILCTRY])) {
            $this->setBillToCountry($data[self::COLUMN_BILCTRY]);
        }

        if (isset($data[self::COLUMN_BILPSTL])) {
            $this->setBillToZipPostalCode($data[self::COLUMN_BILPSTL]);
        }

        if (isset($data[self::COLUMN_CNTPHONE])) {
            $this->setContactPhoneNumber($data[self::COLUMN_CNTPHONE]);
        }

        if (isset($data[self::COLUMN_EXPYEAR])) {
            $this->setExpiryYear($data[self::COLUMN_EXPYEAR]);
        }

        if (isset($data[self::COLUMN_EXPMONTH])) {
            $this->setExpiryMonth($data[self::COLUMN_EXPMONTH]);
        }

        if (isset($data[self::COLUMN_TRNSLMT])) {
            $this->setTransactionLimit($data[self::COLUMN_TRNSLMT]);
        }

        if (isset($data[self::COLUMN_DFLTCARD])) {
            $this->setDefaultCard((bool)$data[self::COLUMN_DFLTCARD]);
        }

        if (isset($data[self::COLUMN_AVS])) {
            $this->setAVSMessage($data[self::COLUMN_AVS]);
        }

        if (isset($data[self::COLUMN_CVV])) {
            $this->setCVVMessage($data[self::COLUMN_CVV]);
        }

        if (isset($data[self::COLUMN_ISSTORED])) {
            $this->setIsCardStored((bool)$data[self::COLUMN_ISSTORED]);
        }

        if (isset($data[self::COLUMN_EMAIL])) {
            $this->setEmail($data[self::COLUMN_EMAIL]);
        }

        if (isset($data[self::COLUMN_SWIPEOPT])) {
            $this->setWasCardSwiped((bool)$data[self::COLUMN_SWIPEOPT]);
        }

        if (isset($data[self::COLUMN_APPROFILEID])) {
            $this->setPaymentProfile((string)$data[self::COLUMN_APPROFILEID]);
        }

        if (isset($data[self::COLUMN_CCNETWORK])) {
            $this->setCreditCardNetwork($data[self::COLUMN_CCNETWORK]);
        }
    }

    public function updateFromArray(array $cardData)
    {
    }
}
