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
    public const COLUMN_ID                              = 'entity_id';

    /**
     * Points to online NNCARD record used on order - ecinternet_paytelligence_card.entity_id
     */
    public const COLUMN_PARENT_CARD_ID                  = 'parent_card_id';

    public const COLUMN_CREATED_AT                      = 'created_at';

    public const COLUMN_UPDATED_AT                      = 'updated_at';

    public const COLUMN_TRNSNUM                         = 'TRNSNUM';

    public const COLUMN_CARDID                          = 'CARDID';

    public const COLUMN_CARDNUM                         = 'CARDNUM';

    public const COLUMN_MERCODE                         = 'MERCODE';

    public const COLUMN_PARENTID                        = 'PARENTID';

    public const COLUMN_TRNSSRC                         = 'TRNSSRC';

    public const COLUMN_AUTHED                          = 'AUTHED';

    public const COLUMN_TRNSTYPE                        = 'TRNSTYPE';

    public const COLUMN_TRNSSTTE                        = 'TRNSSTTE';

    public const COLUMN_TRNSDATE                        = 'TRNSDATE';

    public const COLUMN_TRNSTIME                        = 'TRNSTIME';

    public const COLUMN_DOCCURR                         = 'DOCCURR';

    public const COLUMN_DOCAMT                          = 'DOCAMT';

    public const COLUMN_TRNSCURR                        = 'TRNSCURR';

    public const COLUMN_TRNSAMT                         = 'TRNSAMT';

    public const COLUMN_DISCAMT                         = 'DISCAMT';

    public const COLUMN_CONV                            = 'CONV';

    public const COLUMN_RATEOP                          = 'RATEOP';

    public const COLUMN_AUTHAMT                         = 'AUTHAMT';

    public const COLUMN_CAPAMT                          = 'CAPAMT';

    public const COLUMN_REFAMT                          = 'REFAMT';

    public const COLUMN_ADDCHRG                         = 'ADDCHRG';

    public const COLUMN_ORDERNUM                        = 'ORDERNUM';

    public const COLUMN_PONUM                           = 'PONUM';

    public const COLUMN_DOCNUM                          = 'DOCNUM';

    public const COLUMN_DOCTYPE                         = 'DOCTYPE';

    public const COLUMN_CUSTOMER                        = 'CUSTOMER';

    public const COLUMN_LOCATION                        = 'LOCATION';

    public const COLUMN_GWTRNSID                        = 'GWTRNSID';

    public const COLUMN_GWREFCDE                        = 'GWREFCDE';

    public const COLUMN_GWORDRID                        = 'GWORDRID';

    public const COLUMN_TRNSCMT                         = 'TRNSCMT';

    public const COLUMN_TRNSRESD                        = 'TRNSRESD';

    public const COLUMN_GLACCTNO                        = 'GLACCTNO';

    public const COLUMN_ARBNUM                          = 'ARBNUM';

    public const COLUMN_ARBENUM                         = 'ARBENUM';

    public const COLUMN_ASDCTYPE                        = 'ASDCTYPE';

    public const COLUMN_ASDCNUM                         = 'ASDCNUM';

    public const COLUMN_CNTPAYM                         = 'CNTPAYM';

    public const COLUMN_TESTMODE                        = 'TESTMODE';

    /**
     * Magento order increment id
     */
    public const COLUMN_INCREMENT_ID                    = 'increment_id';

    /**
     * Magento order id
     */
    public const COLUMN_ORDER_ID                        = 'order_id';

    /**
     * Magento customer id
     */
    public const COLUMN_CUSTOMER_ID                     = 'customer_id';

    public const COLUMN_PARENT_TRANSACTION_ID           = 'parent_transaction_id';

    public const COLUMN_AREA_CODE                       = 'area_code';

    /**
     * Sage customer number
     */
    public const COLUMN_SAGE_IDCUST                     = 'sage_idcust';

    /**
     * Sage transaction id
     */
    public const COLUMN_SAGE_NNTRANS_ID                 = 'sage_nntrans_id';

    public const TRANSACTION_SOURCE_IMPORTED            = 9;

    public const TRANSACTION_TYPE_ADD_PROFILE           = 1;

    public const TRANSACTION_TYPE_UPDATE_PROFILE        = 2;

    public const TRANSACTION_TYPE_AUTHORIZE             = 10;

    public const TRANSACTION_TYPE_SALE                  = 12;

    public const TRANSACTION_STATE_ENTERED              = 2;

    public const TRANSACTION_STATE_TRANSMITTED          = 3;

    public const DOCUMENT_TYPE_NONE                     = 0;

    public const DOCUMENT_TYPE_ORDER                    = 3;

    public const ASSIGNED_DOCUMENT_NUMBER_NONE          = 0;

    public const AR_BATCH_NUMBER_STATUS_NOT_YET_BATCHED = 0;

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
