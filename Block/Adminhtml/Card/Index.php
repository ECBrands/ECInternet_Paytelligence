<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Block\Adminhtml\Card;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Template;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Framework\Registry;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Directory\Helper\Data as DirectoryHelper;
use ECInternet\Paytelligence\Helper\Customer as CustomerHelper;
use ECInternet\Paytelligence\Helper\Data;

class Index extends Template
{
    protected $_template = 'ECInternet_Paytelligence::card/index.phtml';

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \ECInternet\Paytelligence\Helper\Customer
     */
    private $customerHelper;

    /**
     * @var \ECInternet\Paytelligence\Helper\Data
     */
    private $helper;

    /**
     * @param \Magento\Backend\Block\Template\Context           $context
     * @param \Magento\Framework\Registry                       $registry
     * @param \ECInternet\Paytelligence\Helper\Customer         $customerHelper
     * @param \ECInternet\Paytelligence\Helper\Data             $helper
     * @param array                                             $data
     * @param \Magento\Framework\Json\Helper\Data|null          $jsonHelper
     * @param \Magento\Directory\Helper\Data|null               $directoryHelper
     */
    public function __construct(
        Context $context,
        Registry $registry,
        CustomerHelper $customerHelper,
        Data $helper,
        array $data = [],
        ?JsonHelper $jsonHelper = null,
        ?DirectoryHelper $directoryHelper = null
    ) {
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);

        $this->coreRegistry   = $registry;
        $this->customerHelper = $customerHelper;
        $this->helper         = $helper;
    }

    public function getCards()
    {
        $customerId = $this->getCustomerId();
        if (is_numeric($customerId)) {
            if ($customer = $this->getCustomerById((int)$customerId)) {
                if ($cards = $this->helper->getStoredCardCollectionForCustomer($customer)) {
                    return $cards;
                }
            }
        }

        return null;
    }

    /**
     * Pull 'current_customer_id' from registry (not sure why not using customer session))
     *
     * @return mixed|null
     */
    private function getCustomerId()
    {
        return $this->coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    /**
     * @param int $customerId
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    private function getCustomerById(int $customerId)
    {
        return $this->customerHelper->getCustomerById($customerId);
    }
}
