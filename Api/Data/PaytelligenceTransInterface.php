<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api\Data;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
interface PaytelligenceTransInterface
{
    const COLUMN_ID                              = 'entity_id';

    /**
     * Points to online NNCARD record used on order - ecinternet_paytelligence_card.entity_id
     */
    const COLUMN_PARENT_CARD_ID                  = 'parent_card_id';

    const COLUMN_CREATED_AT                      = 'created_at';

    const COLUMN_UPDATED_AT                      = 'updated_at';

    const COLUMN_TRNSNUM                         = 'TRNSNUM';

    const COLUMN_CARDID                          = 'CARDID';

    const COLUMN_CARDNUM                         = 'CARDNUM';

    const COLUMN_MERCODE                         = 'MERCODE';

    const COLUMN_PARENTID                        = 'PARENTID';

    const COLUMN_TRNSSRC                         = 'TRNSSRC';

    const COLUMN_AUTHED                          = 'AUTHED';

    const COLUMN_TRNSTYPE                        = 'TRNSTYPE';

    const COLUMN_TRNSSTTE                        = 'TRNSSTTE';

    const COLUMN_TRNSDATE                        = 'TRNSDATE';

    const COLUMN_TRNSTIME                        = 'TRNSTIME';

    const COLUMN_DOCCURR                         = 'DOCCURR';

    const COLUMN_DOCAMT                          = 'DOCAMT';

    const COLUMN_TRNSCURR                        = 'TRNSCURR';

    const COLUMN_TRNSAMT                         = 'TRNSAMT';

    const COLUMN_DISCAMT                         = 'DISCAMT';

    const COLUMN_CONV                            = 'CONV';

    const COLUMN_RATEOP                          = 'RATEOP';

    const COLUMN_AUTHAMT                         = 'AUTHAMT';

    const COLUMN_CAPAMT                          = 'CAPAMT';

    const COLUMN_REFAMT                          = 'REFAMT';

    const COLUMN_ADDCHRG                         = 'ADDCHRG';

    const COLUMN_ORDERNUM                        = 'ORDERNUM';

    const COLUMN_PONUM                           = 'PONUM';

    const COLUMN_DOCNUM                          = 'DOCNUM';

    const COLUMN_DOCTYPE                         = 'DOCTYPE';

    const COLUMN_CUSTOMER                        = 'CUSTOMER';

    const COLUMN_LOCATION                        = 'LOCATION';

    const COLUMN_GWTRNSID                        = 'GWTRNSID';

    const COLUMN_GWREFCDE                        = 'GWREFCDE';

    const COLUMN_GWORDRID                        = 'GWORDRID';

    const COLUMN_TRNSCMT                         = 'TRNSCMT';

    const COLUMN_TRNSRESD                        = 'TRNSRESD';

    const COLUMN_GLACCTNO                        = 'GLACCTNO';

    const COLUMN_ARBNUM                          = 'ARBNUM';

    const COLUMN_ARBENUM                         = 'ARBENUM';

    const COLUMN_ASDCTYPE                        = 'ASDCTYPE';

    const COLUMN_ASDCNUM                         = 'ASDCNUM';

    const COLUMN_CNTPAYM                         = 'CNTPAYM';

    const COLUMN_TESTMODE                        = 'TESTMODE';

    /**
     * Magento order increment id
     */
    const COLUMN_INCREMENT_ID                    = 'increment_id';

    /**
     * Magento order id
     */
    const COLUMN_ORDER_ID                        = 'order_id';

    /**
     * Magento customer id
     */
    const COLUMN_CUSTOMER_ID                     = 'customer_id';

    const COLUMN_PARENT_TRANSACTION_ID           = 'parent_transaction_id';

    const COLUMN_AREA_CODE                       = 'area_code';

    /**
     * Sage customer number
     */
    const COLUMN_SAGE_IDCUST                     = 'sage_idcust';

    /**
     * Sage transaction id
     */
    const COLUMN_SAGE_NNTRANS_ID                 = 'sage_nntrans_id';

    const TRANSACTION_SOURCE_IMPORTED            = 9;

    const TRANSACTION_TYPE_ADD_PROFILE           = 1;

    const TRANSACTION_TYPE_UPDATE_PROFILE        = 2;

    const TRANSACTION_TYPE_AUTHORIZE             = 10;

    const TRANSACTION_TYPE_SALE                  = 12;

    const TRANSACTION_STATE_ENTERED              = 2;

    const TRANSACTION_STATE_TRANSMITTED          = 3;

    const DOCUMENT_TYPE_NONE                     = 0;

    const DOCUMENT_TYPE_ORDER                    = 3;

    const ASSIGNED_DOCUMENT_NUMBER_NONE          = 0;

    const AR_BATCH_NUMBER_STATUS_NOT_YET_BATCHED = 0;

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return int
     */
    public function getParentCardId();

    /**
     * @param int $parentCardId
     *
     * @return void
     */
    public function setParentCardId(int $parentCardId);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @return int
     */
    public function getTransactionNumber();

    /**
     * @param int $transactionNumber
     *
     * @return void
     */
    public function setTransactionNumber(int $transactionNumber);

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
    public function getCardNumber();

    /**
     * @param string $cardNumber
     *
     * @return void
     */
    public function setCardNumber(string $cardNumber);

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
    public function getParentId();

    /**
     * @param string $parentId
     *
     * @return void
     */
    public function setParentId(string $parentId);

    /**
     * @return int
     */
    public function getTransactionSource();

    /**
     * @param int $transactionSource
     *
     * @return void
     */
    public function setTransactionSource(int $transactionSource);

    /**
     * @return int
     */
    public function getAuthorizedStatus();

    /**
     * @param int $authorizedStatus
     *
     * @return void
     */
    public function setAuthorizedStatus(int $authorizedStatus);

    /**
     * @return int
     */
    public function getTransactionType();

    /**
     * @param int $transactionType
     *
     * @return void
     */
    public function setTransactionType(int $transactionType);

    /**
     * @return int
     */
    public function getTransactionState();

    /**
     * @param int $transactionState
     *
     * @return void
     */
    public function setTransactionState(int $transactionState);

    /**
     * @return string
     */
    public function getTransactionDate();

    /**
     * @param string $transactionDate
     *
     * @return void
     */
    public function setTransactionDate(string $transactionDate);

    /**
     * @return string
     */
    public function getTransactionTime();

    /**
     * @param string $transactionTime
     *
     * @return void
     */
    public function setTransactionTime(string $transactionTime);

    /**
     * @return string
     */
    public function getDocumentCurrency();

    /**
     * @param string $documentCurrency
     *
     * @return void
     */
    public function setDocumentCurrency(string $documentCurrency);

    /**
     * @return float
     */
    public function getDocumentAmount();

    /**
     * @param float $documentAmount
     *
     * @return void
     */
    public function setDocumentAmount(float $documentAmount);

    /**
     * @return string
     */
    public function getTransactionCurrency();

    /**
     * @param string $transactionCurrency
     *
     * @return void
     */
    public function setTransactionCurrency(string $transactionCurrency);

    /**
     * @return float
     */
    public function getTransactionAmount();

    /**
     * @param float $transactionAmount
     *
     * @return void
     */
    public function setTransactionAmount(float $transactionAmount);

    /**
     * @return float
     */
    public function getDiscountAmount();

    /**
     * @param float $discountAmount
     *
     * @return void
     */
    public function setDiscountAmount(float $discountAmount);

    /**
     * @return float
     */
    public function getConversionRate();

    /**
     * @param float $conversionRate
     *
     * @return void
     */
    public function setConversionRate(float $conversionRate);

    /**
     * @return int
     */
    public function getRateOperator();

    /**
     * @param int $rateOperator
     *
     * @return void
     */
    public function setRateOperator(int $rateOperator);

    /**
     * @return float
     */
    public function getAuthorizeAmount();

    /**
     * @param float $authorizeAmount
     *
     * @return void
     */
    public function setAuthorizeAmount(float $authorizeAmount);

    /**
     * @return float
     */
    public function getCaptureAmount();

    /**
     * @param float $captureAmount
     *
     * @return void
     */
    public function setCaptureAmount(float $captureAmount);

    /**
     * @return float
     */
    public function getReferenceAmount();

    /**
     * @param float $referenceAmount
     *
     * @return void
     */
    public function setReferenceAmount(float $referenceAmount);

    /**
     * @return float
     */
    public function getAdditionalCharges();

    /**
     * @param float $additionalCharges
     *
     * @return void
     */
    public function setAdditionalCharges(float $additionalCharges);

    /**
     * @return string
     */
    public function getOrderNumber();

    /**
     * @param string $orderNumber
     *
     * @return void
     */
    public function setOrderNumber(string $orderNumber);

    /**
     * @return string
     */
    public function getCustomerPONumber();

    /**
     * @param string $poNumber
     *
     * @return void
     */
    public function setCustomerPONumber(string $poNumber);

    /**
     * @return string
     */
    public function getDocumentNumber();

    /**
     * @param string $documentNumber
     *
     * @return void
     */
    public function setDocumentNumber(string $documentNumber);

    /**
     * @return int
     */
    public function getDocumentType();

    /**
     * @param int $documentType
     *
     * @return void
     */
    public function setDocumentType(int $documentType);

    /**
     * @return string
     */
    public function getCustomerNumber();

    /**
     * @param string $customerNumber
     *
     * @return void
     */
    public function setCustomerNumber(string $customerNumber);

    /**
     * @return string
     */
    public function getLocationCode();

    /**
     * @param string $locationCode
     *
     * @return void
     */
    public function setLocationCode(string $locationCode);

    /**
     * @return string
     */
    public function getGatewayTransactionId();

    /**
     * @param string $gatewayTransactionId
     *
     * @return void
     */
    public function setGatewayTransactionId(string $gatewayTransactionId);

    /**
     * @return string
     */
    public function getGatewayReferenceCode();

    /**
     * @param string $gatewayReferenceCode
     *
     * @return void
     */
    public function setGatewayReferenceCode(string $gatewayReferenceCode);

    /**
     * @return string
     */
    public function getGatewayOrderId();

    /**
     * @param string $gatewayOrderId
     *
     * @return void
     */
    public function setGatewayOrderId(string $gatewayOrderId);

    /**
     * @return string
     */
    public function getTransactionComment();

    /**
     * @param string $transactionComment
     *
     * @return void
     */
    public function setTransactionComment(string $transactionComment);

    /**
     * @return string
     */
    public function getReserved();

    /**
     * @param string $reserved
     *
     * @return void
     */
    public function setReserved(string $reserved);

    /**
     * @return string
     */
    public function getGLAccountNumber();

    /**
     * @param string $glAccountNumber
     *
     * @return void
     */
    public function setGLAccountNumber(string $glAccountNumber);

    /**
     * @return int
     */
    public function getARBatchNumber();

    /**
     * @param int $arBatchNumber
     *
     * @return void
     */
    public function setARBatchNumber(int $arBatchNumber);

    /**
     * @return int
     */
    public function getARBatchEntryNumber();

    /**
     * @param int $arBatchEntryNumber
     *
     * @return void
     */
    public function setARBatchEntryNumber(int $arBatchEntryNumber);

    /**
     * @return int
     */
    public function getAssignedDocumentType();

    /**
     * @param int $assignedDocumentType
     *
     * @return void
     */
    public function setAssignedDocumentType(int $assignedDocumentType);

    /**
     * @return string
     */
    public function getAssignedDocumentNumber();

    /**
     * @param string $assignedDocumentNumber
     *
     * @return void
     */
    public function setAssignedDocumentNumber(string $assignedDocumentNumber);

    /**
     * @return string
     */
    public function getPaymentNumber();

    /**
     * @param string $paymentNumber
     *
     * @return void
     */
    public function setPaymentNumber(string $paymentNumber);

    /**
     * @return int
     */
    public function getTestMode();

    /**
     * @param int $testMode
     *
     * @return void
     */
    public function setTestMode(int $testMode);

    /**
     * @return string
     */
    public function getIncrementId();

    /**
     * @param string $incrementId
     *
     * @return void
     */
    public function setIncrementId(string $incrementId);

    /**
     * @return int
     */
    public function getOrderId();

    /**
     * @param int $orderId
     *
     * @return void
     */
    public function setOrderId(int $orderId);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     *
     * @return void
     */
    public function setCustomerId(int $customerId);

    /**
     * @return string
     */
    public function getAreaCode();

    /**
     * @param string $areaCode
     *
     * @return void
     */
    public function setAreaCode(string $areaCode);

    /**
     * @return string
     */
    public function getSageCustomerNumber();

    /**
     * @param string $customerNumber
     *
     * @return void
     */
    public function setSageCustomerNumber(string $customerNumber);

    /**
     * @return int
     */
    public function getSageTransactionId();

    /**
     * @param int $transactionId
     *
     * @return void
     */
    public function setSageTransactionId(int $transactionId);
}
