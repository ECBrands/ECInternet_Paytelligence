<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use ECInternet\Paytelligence\Api\Data\PaytelligenceTransInterface;

/**
 * PaytelligenceTrans model
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PaytelligenceTrans extends AbstractModel implements IdentityInterface, PaytelligenceTransInterface
{
    private const CACHE_TAG = 'paytelligence_trans';

    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'paytelligence_paytelligence_trans';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\PaytelligenceTrans::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->getData(self::COLUMN_ID);
    }

    public function getParentCardId()
    {
        return $this->getData(self::COLUMN_PARENT_CARD_ID);
    }

    public function setParentCardId($parentCardId)
    {
        return $this->setData(self::COLUMN_PARENT_CARD_ID, $parentCardId);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::COLUMN_CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::COLUMN_UPDATED_AT);
    }

    public function getTransactionNumber()
    {
        return $this->getData(self::COLUMN_TRNSNUM);
    }

    /**
     * @param string $transactionNumber
     */
    public function setTransactionNumber($transactionNumber)
    {
        $this->setData(self::COLUMN_TRNSNUM, $transactionNumber);
    }

    public function getCardId()
    {
        return $this->getData(self::COLUMN_CARDID);
    }

    public function setCardId($cardId)
    {
        $this->setData(self::COLUMN_CARDID, $cardId);
    }

    public function getCardNumber()
    {
        return (string)$this->getData(self::COLUMN_CARDNUM);
    }

    public function setCardNumber($cardNumber)
    {
        $this->setData(self::COLUMN_CARDNUM, $cardNumber);
    }

    /**
     * @return string
     */
    public function getMerchantCode()
    {
        return (string)$this->getData(self::COLUMN_MERCODE);
    }

    /**
     * @param string $merchantCode
     */
    public function setMerchantCode(string $merchantCode)
    {
        $this->setData(self::COLUMN_MERCODE, $merchantCode);
    }

    public function getParentId()
    {
        return $this->getData(self::COLUMN_PARENTID);
    }

    public function setParentId(string $parentId)
    {
        $this->setData(self::COLUMN_PARENTID, $parentId);
    }

    public function getTransactionSource()
    {
        return $this->getData(self::COLUMN_TRNSSRC);
    }

    public function setTransactionSource($transactionSource)
    {
        $this->setData(self::COLUMN_TRNSSRC, $transactionSource);
    }

    public function getAuthorizedStatus()
    {
        return $this->getData(self::COLUMN_AUTHED);
    }

    public function setAuthorizedStatus($authorizedStatus)
    {
        $this->setData(self::COLUMN_AUTHED, $authorizedStatus);
    }

    public function getTransactionType()
    {
        return $this->getData(self::COLUMN_TRNSTYPE);
    }

    public function setTransactionType($transactionType)
    {
        $this->setData(self::COLUMN_TRNSTYPE, $transactionType);
    }

    public function getTransactionState()
    {
        return $this->getData(self::COLUMN_TRNSSTTE);
    }

    public function setTransactionState($transactionState)
    {
        $this->setData(self::COLUMN_TRNSSTTE, $transactionState);
    }

    public function getTransactionDate()
    {
        return $this->getData(self::COLUMN_TRNSDATE);
    }

    public function setTransactionDate($transactionDate)
    {
        $this->setData(self::COLUMN_TRNSDATE, $transactionDate);
    }

    public function getTransactionTime()
    {
        return $this->getData(self::COLUMN_TRNSTIME);
    }

    public function setTransactionTime($transactionTime)
    {
        $this->setData(self::COLUMN_TRNSTIME, $transactionTime);
    }

    public function getDocumentCurrency()
    {
        return $this->getData(self::COLUMN_DOCCURR);
    }

    public function setDocumentCurrency($documentCurrency)
    {
        $this->setData(self::COLUMN_DOCCURR, $documentCurrency);
    }

    public function getDocumentAmount()
    {
        return $this->getData(self::COLUMN_DOCAMT);
    }

    public function setDocumentAmount($documentAmount)
    {
        $this->setData(self::COLUMN_DOCAMT, $documentAmount);
    }

    public function getTransactionCurrency()
    {
        return $this->getData(self::COLUMN_TRNSCURR);
    }

    public function setTransactionCurrency($transactionCurrency)
    {
        $this->setData(self::COLUMN_TRNSCURR, $transactionCurrency);
    }

    public function getTransactionAmount()
    {
        return $this->getData(self::COLUMN_TRNSAMT);
    }

    public function setTransactionAmount($transactionAmount)
    {
        $this->setData(self::COLUMN_TRNSAMT, $transactionAmount);
    }

    public function getDiscountAmount()
    {
        $this->getData(self::COLUMN_DISCAMT);
    }

    public function setDiscountAmount($discountAmount)
    {
        $this->setData(self::COLUMN_DISCAMT, $discountAmount);
    }

    public function getConversionRate()
    {
        return $this->getData(self::COLUMN_CONV);
    }

    public function setConversionRate($conversionRate)
    {
        $this->setData(self::COLUMN_CONV, $conversionRate);
    }

    public function getRateOperator()
    {
        return $this->getData(self::COLUMN_RATEOP);
    }

    public function setRateOperator($rateOperator)
    {
        $this->setData(self::COLUMN_RATEOP, $rateOperator);
    }

    public function getAuthorizeAmount()
    {
        return $this->getData(self::COLUMN_AUTHAMT);
    }

    public function setAuthorizeAmount($authorizeAmount)
    {
        $this->setData(self::COLUMN_AUTHAMT, $authorizeAmount);
    }

    public function getCaptureAmount()
    {
        return $this->getData(self::COLUMN_CAPAMT);
    }

    public function setCaptureAmount($captureAmount)
    {
        $this->setData(self::COLUMN_CAPAMT, $captureAmount);
    }

    public function getReferenceAmount()
    {
        return $this->getData(self::COLUMN_REFAMT);
    }

    public function setReferenceAmount($referenceAmount)
    {
        $this->setData(self::COLUMN_REFAMT, $referenceAmount);
    }

    public function getAdditionalCharges()
    {
        return $this->getData(self::COLUMN_ADDCHRG);
    }

    public function setAdditionalCharges($additionalCharges)
    {
        $this->setData(self::COLUMN_ADDCHRG, $additionalCharges);
    }

    public function getOrderNumber()
    {
        return $this->getData(self::COLUMN_ORDERNUM);
    }

    public function setOrderNumber($orderNumber)
    {
        $this->setData(self::COLUMN_ORDERNUM, $orderNumber);
    }

    public function getCustomerPONumber()
    {
        return $this->getData(self::COLUMN_PONUM);
    }

    public function setCustomerPONumber($poNumber)
    {
        $this->setData(self::COLUMN_PONUM, $poNumber);
    }

    public function getDocumentNumber()
    {
        return $this->getData(self::COLUMN_DOCNUM);
    }

    public function setDocumentNumber($documentNumber)
    {
        $this->setData(self::COLUMN_DOCNUM, $documentNumber);
    }

    public function getDocumentType()
    {
        return $this->getData(self::COLUMN_DOCTYPE);
    }

    public function setDocumentType($documentType)
    {
        $this->setData(self::COLUMN_DOCTYPE, $documentType);
    }

    public function getCustomerNumber()
    {
        return $this->getData(self::COLUMN_CUSTOMER);
    }

    public function setCustomerNumber($customerNumber)
    {
        $this->setData(self::COLUMN_CUSTOMER, $customerNumber);
    }

    public function getLocationCode()
    {
        return $this->getData(self::COLUMN_LOCATION);
    }

    public function setLocationCode($locationCode)
    {
        $this->setData(self::COLUMN_LOCATION, $locationCode);
    }

    public function getGatewayTransactionId()
    {
        return $this->getData(self::COLUMN_GWTRNSID);
    }

    public function setGatewayTransactionId($gatewayTransactionId)
    {
        $this->setData(self::COLUMN_GWTRNSID, $gatewayTransactionId);
    }

    public function getGatewayReferenceCode()
    {
        return $this->getData(self::COLUMN_GWREFCDE);
    }

    public function setGatewayReferenceCode($gatewayReferenceCode)
    {
        $this->setData(self::COLUMN_GWREFCDE, $gatewayReferenceCode);
    }

    public function getGatewayOrderId()
    {
        return $this->getData(self::COLUMN_GWORDRID);
    }

    public function setGatewayOrderId($gatewayOrderId)
    {
        $this->setData(self::COLUMN_GWORDRID, $gatewayOrderId);
    }

    public function getTransactionComment()
    {
        return $this->getData(self::COLUMN_TRNSCMT);
    }

    public function setTransactionComment($transactionComment)
    {
        $this->setData(self::COLUMN_TRNSCMT, $transactionComment);
    }

    public function getReserved()
    {
        return $this->getData(self::COLUMN_TRNSRESD);
    }

    public function setReserved($reserved)
    {
        $this->setData(self::COLUMN_TRNSRESD, $reserved);
    }

    public function getGLAccountNumber()
    {
        return $this->getData(self::COLUMN_GLACCTNO);
    }

    public function setGLAccountNumber($glAccountNumber)
    {
        $this->setData(self::COLUMN_GLACCTNO, $glAccountNumber);
    }

    public function getARBatchNumber()
    {
        return $this->getData(self::COLUMN_ARBNUM);
    }

    public function setARBatchNumber($arBatchNumber)
    {
        $this->setData(self::COLUMN_ARBNUM, $arBatchNumber);
    }

    public function getARBatchEntryNumber()
    {
        return $this->getData(self::COLUMN_ARBENUM);
    }

    public function setARBatchEntryNumber($arBatchEntryNumber)
    {
        $this->setData(self::COLUMN_ARBENUM, $arBatchEntryNumber);
    }

    public function getAssignedDocumentType()
    {
        return $this->getData(self::COLUMN_ASDCTYPE);
    }

    public function setAssignedDocumentType($assignedDocumentType)
    {
        $this->setData(self::COLUMN_ASDCTYPE, $assignedDocumentType);
    }

    public function getAssignedDocumentNumber()
    {
        return $this->getData(self::COLUMN_ASDCNUM);
    }

    public function setAssignedDocumentNumber($assignedDocumentNumber)
    {
        $this->setData(self::COLUMN_ASDCNUM, $assignedDocumentNumber);
    }

    public function getPaymentNumber()
    {
        return $this->getData(self::COLUMN_CNTPAYM);
    }

    public function setPaymentNumber($paymentNumber)
    {
        $this->setData(self::COLUMN_CNTPAYM, $paymentNumber);
    }

    public function getTestMode()
    {
        return $this->getData(self::COLUMN_TESTMODE);
    }

    public function setTestMode($testMode)
    {
        $this->setData(self::COLUMN_TESTMODE, $testMode);
    }

    public function getIncrementId()
    {
        return $this->getData(self::COLUMN_INCREMENT_ID);
    }

    public function setIncrementId($incrementId)
    {
        $this->setData(self::COLUMN_INCREMENT_ID, $incrementId);
    }

    public function getOrderId()
    {
        return (int)$this->getData(self::COLUMN_ORDER_ID);
    }

    public function setOrderId(int $orderId)
    {
        $this->setData(self::COLUMN_ORDER_ID, $orderId);
    }

    public function getCustomerId()
    {
        return $this->getData(self::COLUMN_CUSTOMER_ID);
    }

    public function setCustomerId($customerId)
    {
        $this->setData(self::COLUMN_CUSTOMER_ID, $customerId);
    }

    public function getParentTransactionId()
    {
        return $this->getData(self::COLUMN_PARENT_TRANSACTION_ID);
    }

    public function setParentTransactionId($parentTransactionId)
    {
        $this->setData(self::COLUMN_PARENT_TRANSACTION_ID, $parentTransactionId);
    }

    public function getAreaCode()
    {
        $this->getData(self::COLUMN_AREA_CODE);
    }

    public function setAreaCode($areaCode)
    {
        $this->setData(self::COLUMN_AREA_CODE, $areaCode);
    }

    public function getSageCustomerNumber()
    {
        return $this->getData(self::COLUMN_SAGE_IDCUST);
    }

    public function setSageCustomerNumber($customerNumber)
    {
        $this->setData(self::COLUMN_SAGE_IDCUST, $customerNumber);
    }

    public function getSageTransactionId()
    {
        return $this->getData(self::COLUMN_SAGE_NNTRANS_ID);
    }

    public function setSageTransactionId($transactionId)
    {
        $this->setData(self::COLUMN_SAGE_NNTRANS_ID, $transactionId);
    }

    public function updateFromArray(array $data)
    {
        if (isset($data[PaytelligenceTrans::COLUMN_PARENT_CARD_ID])) {
            $this->setParentCardId($data[PaytelligenceTrans::COLUMN_PARENT_CARD_ID]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_CARDID])) {
            $this->setCardId($data[PaytelligenceTrans::COLUMN_CARDID]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_CARDNUM])) {
            $this->setCardNumber($data[PaytelligenceTrans::COLUMN_CARDNUM]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_MERCODE])) {
            $this->setMerchantCode($data[PaytelligenceTrans::COLUMN_MERCODE]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_PARENTID])) {
            $this->setParentId($data[PaytelligenceTrans::COLUMN_PARENTID]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_TRNSSRC])) {
            $this->setTransactionSource($data[PaytelligenceTrans::COLUMN_TRNSSRC]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_AUTHED])) {
            $this->setAuthorizedStatus($data[PaytelligenceTrans::COLUMN_AUTHED]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_TRNSTYPE])) {
            $this->setTransactionType($data[PaytelligenceTrans::COLUMN_TRNSTYPE]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_TRNSSTTE])) {
            $this->setTransactionState($data[PaytelligenceTrans::COLUMN_TRNSSTTE]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_TRNSDATE])) {
            $this->setTransactionDate($data[PaytelligenceTrans::COLUMN_TRNSDATE]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_TRNSTIME])) {
            $this->setTransactionTime($data[PaytelligenceTrans::COLUMN_TRNSTIME]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_DOCCURR])) {
            $this->setDocumentCurrency($data[PaytelligenceTrans::COLUMN_DOCCURR]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_DOCAMT])) {
            $this->setDocumentAmount($data[PaytelligenceTrans::COLUMN_DOCAMT]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_TRNSCURR])) {
            $this->setTransactionCurrency($data[PaytelligenceTrans::COLUMN_TRNSCURR]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_TRNSAMT])) {
            $this->setTransactionAmount($data[PaytelligenceTrans::COLUMN_TRNSAMT]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_CONV])) {
            $this->setConversionRate($data[PaytelligenceTrans::COLUMN_CONV]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_RATEOP])) {
            $this->setRateOperator($data[PaytelligenceTrans::COLUMN_RATEOP]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_AUTHAMT])) {
            $this->setAuthorizeAmount($data[PaytelligenceTrans::COLUMN_AUTHAMT]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_CAPAMT])) {
            $this->setCaptureAmount($data[PaytelligenceTrans::COLUMN_CAPAMT]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_ADDCHRG])) {
            $this->setAdditionalCharges($data[PaytelligenceTrans::COLUMN_ADDCHRG]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_ORDERNUM])) {
            $this->setOrderNumber($data[PaytelligenceTrans::COLUMN_ORDERNUM]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_DOCNUM])) {
            $this->setDocumentNumber($data[PaytelligenceTrans::COLUMN_DOCNUM]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_DOCTYPE])) {
            $this->setDocumentType($data[PaytelligenceTrans::COLUMN_DOCTYPE]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_CUSTOMER])) {
            $this->setCustomerNumber($data[PaytelligenceTrans::COLUMN_CUSTOMER]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_GWTRNSID])) {
            $this->setGatewayTransactionId($data[PaytelligenceTrans::COLUMN_GWTRNSID]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_GWREFCDE])) {
            $this->setGatewayReferenceCode($data[PaytelligenceTrans::COLUMN_GWREFCDE]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_GWORDRID])) {
            $this->setGatewayOrderId($data[PaytelligenceTrans::COLUMN_GWORDRID]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_TRNSCMT])) {
            $this->setTransactionComment($data[PaytelligenceTrans::COLUMN_TRNSCMT]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_ARBNUM])) {
            $this->setARBatchNumber($data[PaytelligenceTrans::COLUMN_ARBNUM]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_ARBENUM])) {
            $this->setARBatchEntryNumber($data[PaytelligenceTrans::COLUMN_ARBENUM]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_ASDCTYPE])) {
            $this->setAssignedDocumentType($data[PaytelligenceTrans::COLUMN_ASDCTYPE]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_TESTMODE])) {
            $this->setTestMode($data[PaytelligenceTrans::COLUMN_TESTMODE]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_INCREMENT_ID])) {
            $this->setIncrementId($data[PaytelligenceTrans::COLUMN_INCREMENT_ID]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_ORDER_ID])) {
            if (is_numeric($data[PaytelligenceTrans::COLUMN_ORDER_ID])) {
                $this->setOrderId((int)$data[PaytelligenceTrans::COLUMN_ORDER_ID]);
            }
        }

        if (isset($data[PaytelligenceTrans::COLUMN_CUSTOMER_ID])) {
            $this->setCustomerId($data[PaytelligenceTrans::COLUMN_CUSTOMER_ID]);
        }

        if (isset($data[PaytelligenceTrans::COLUMN_PARENT_TRANSACTION_ID])) {
            if (is_numeric($data[PaytelligenceTrans::COLUMN_PARENT_TRANSACTION_ID])) {
                $this->setParentTransactionId((int)$data[PaytelligenceTrans::COLUMN_PARENT_TRANSACTION_ID]);
            }
        }
    }
}
