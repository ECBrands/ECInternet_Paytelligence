<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Test\Unit\Helper;

use ECInternet\Paytelligence\Helper\Customer;
use Exception;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Api\AttributeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    /** @var CustomerRepositoryInterface|MockObject */
    private $customerRepository;

    /** @var Session|MockObject */
    private $customerSession;

    /** @var Customer */
    private $helper;

    protected function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->customerSession    = $this->createMock(Session::class);

        $sessionFactory = $this->createMock(SessionFactory::class);
        $sessionFactory->method('create')->willReturn($this->customerSession);

        $this->helper = new Customer($this->customerRepository, $sessionFactory);
    }

    // -------------------------------------------------------------------------
    // Tests: getCurrentCustomer() - Returns null
    // -------------------------------------------------------------------------

    public function testGetCurrentCustomerReturnsNullWhenNotLoggedIn(): void
    {
        $this->customerSession->method('isLoggedIn')->willReturn(false);

        $this->assertNull($this->helper->getCurrentCustomer());
    }

    public function testGetCurrentCustomerReturnsNullWhenCustomerIdIsNotNumeric(): void
    {
        $this->customerSession->method('isLoggedIn')->willReturn(true);
        $this->customerSession->method('getCustomerId')->willReturn('not-a-number');

        $this->assertNull($this->helper->getCurrentCustomer());
    }

    public function testGetCurrentCustomerReturnsNullWhenCustomerIdIsEmpty(): void
    {
        $this->customerSession->method('isLoggedIn')->willReturn(true);
        $this->customerSession->method('getCustomerId')->willReturn('');

        $this->assertNull($this->helper->getCurrentCustomer());
    }

    // -------------------------------------------------------------------------
    // Tests: getCurrentCustomer() - Returns Customer
    // -------------------------------------------------------------------------

    public function testGetCurrentCustomerReturnsCustomerWhenLoggedInWithNumericId(): void
    {
        $customer = $this->createMock(CustomerInterface::class);

        $this->customerSession->method('isLoggedIn')->willReturn(true);
        $this->customerSession->method('getCustomerId')->willReturn('42');

        $this->customerRepository
            ->method('getById')
            ->with(42)
            ->willReturn($customer);

        $this->assertSame($customer, $this->helper->getCurrentCustomer());
    }

    // -------------------------------------------------------------------------
    // Tests: getCustomerById()
    // -------------------------------------------------------------------------

    public function testGetCustomerByIdReturnsCustomerForValidId(): void
    {
        $customer = $this->createMock(CustomerInterface::class);

        $this->customerRepository
            ->method('getById')
            ->with(7)
            ->willReturn($customer);

        $this->assertSame($customer, $this->helper->getCustomerById(7));
    }

    public function testGetCustomerByIdReturnsNullWhenRepositoryThrows(): void
    {
        $this->customerRepository
            ->method('getById')
            ->willThrowException(new Exception('Not found'));

        $this->assertNull($this->helper->getCustomerById(999));
    }

    // -------------------------------------------------------------------------
    // Tests: getCustomerNumbers()
    // -------------------------------------------------------------------------

    public function testGetCustomerNumbersAlwaysIncludesTemplatedMageNumber(): void
    {
        $customer = $this->createMock(CustomerInterface::class);
        $customer->method('getId')->willReturn(5);
        $customer->method('getCustomAttribute')->willReturn(null);

        $numbers = $this->helper->getCustomerNumbers($customer);

        $this->assertContains('MAGE-5', $numbers);
    }

    public function testGetCustomerNumbersIncludesCustomAttributeWhenPresent(): void
    {
        $attribute = $this->createMock(AttributeInterface::class);
        $attribute->method('getValue')->willReturn('CUST-001');

        $customer = $this->createMock(CustomerInterface::class);
        $customer->method('getId')->willReturn(10);
        $customer->method('getCustomAttribute')->willReturn($attribute);

        $numbers = $this->helper->getCustomerNumbers($customer);

        $this->assertContains('MAGE-10', $numbers);
        $this->assertContains('CUST-001', $numbers);
        $this->assertCount(2, $numbers);
    }

    public function testGetCustomerNumbersExcludesCustomAttributeWhenValueIsEmpty(): void
    {
        $attribute = $this->createMock(AttributeInterface::class);
        $attribute->method('getValue')->willReturn('');

        $customer = $this->createMock(CustomerInterface::class);
        $customer->method('getId')->willReturn(3);
        $customer->method('getCustomAttribute')->willReturn($attribute);

        $numbers = $this->helper->getCustomerNumbers($customer);

        $this->assertCount(1, $numbers);
        $this->assertSame(['MAGE-3'], $numbers);
    }

    public function testGetCustomerNumbersExcludesCustomAttributeWhenAttributeIsNull(): void
    {
        $customer = $this->createMock(CustomerInterface::class);
        $customer->method('getId')->willReturn(8);
        $customer->method('getCustomAttribute')->willReturn(null);

        $numbers = $this->helper->getCustomerNumbers($customer);

        $this->assertCount(1, $numbers);
        $this->assertSame(['MAGE-8'], $numbers);
    }
}
