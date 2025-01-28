<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\SessionFactory as CustomerSessionFactory;
use Exception;

/**
 * Customer helper
 */
class Customer
{
    const CUSTOMER_NUMBER_ATTRIBUTE = 'customer_number';

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Customer\Model\SessionFactory            $customerSessionFactory
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerSessionFactory $customerSessionFactory
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerSession    = $customerSessionFactory->create();
    }

    public function getCurrentCustomer()
    {
        if ($this->customerSession->isLoggedIn()) {
            if ($customerId = $this->customerSession->getCustomerId()) {
                if (is_numeric($customerId)) {
                    return $this->getCustomerById((int)$customerId);
                }
            }
        }

        return null;

    }

    /**
     * @param int $customerId
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function getCustomerById(int $customerId)
    {
        try {
            return $this->customerRepository->getById($customerId);
        } catch (Exception $e) {
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
        $customerNumbers = [];

        // Add templated customer number
        $customerNumbers[] = 'MAGE-' . $customer->getId();

        // Add customer_number attribute
        if ($customerNumber = $customer->getCustomAttribute(self::CUSTOMER_NUMBER_ATTRIBUTE)) {
            if ($customerNumberValue = $customerNumber->getValue()) {
                $customerNumbers[] = (string)$customerNumberValue;
            }
        }

        return $customerNumbers;
    }
}