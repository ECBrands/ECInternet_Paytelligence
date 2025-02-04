<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Controller;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;
use ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface;
use ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface;
use ECInternet\Paytelligence\Helper\Customer as CustomerHelper;
use ECInternet\Paytelligence\Logger\Logger;
use ECInternet\Paytelligence\Model\Config;
use ECInternet\Paytelligence\Model\PaytelligenceCardFactory;
use Exception;

/**
 * Base Card controller
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
abstract class Card
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface
     */
    protected $paymentGatewayPool;

    /**
     * @var \ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface
     */
    protected $cardRepository;

    /**
     * @var \ECInternet\Paytelligence\Helper\Customer
     */
    protected $customerHelper;

    /**
     * @var \ECInternet\Paytelligence\Logger\Logger
     */
    protected $logger;

    /**
     * @var \ECInternet\Paytelligence\Model\Config
     */
    protected $config;

    /**
     * @var \ECInternet\Paytelligence\Model\PaytelligenceCardFactory
     */
    protected $cardFactory;

    /**
     * Card constructor.
     *
     * @param \Magento\Framework\App\RequestInterface                            $request
     * @param \Magento\Framework\Controller\Result\RedirectFactory               $redirectFactory
     * @param \Magento\Framework\Message\ManagerInterface                        $messageManager
     * @param \Magento\Framework\UrlInterface                                    $url
     * @param \Magento\Framework\View\Result\PageFactory                         $resultPageFactory
     * @param \ECInternet\Paytelligence\Api\PaymentGatewayPoolInterface          $paymentGatewayPool
     * @param \ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface $cardRepository
     * @param \ECInternet\Paytelligence\Helper\Customer                          $customerHelper
     * @param \ECInternet\Paytelligence\Logger\Logger                            $logger
     * @param \ECInternet\Paytelligence\Model\Config                             $config
     * @param \ECInternet\Paytelligence\Model\PaytelligenceCardFactory           $cardFactory
     */
    public function __construct(
        RequestInterface $request,
        RedirectFactory $redirectFactory,
        ManagerInterface $messageManager,
        UrlInterface $url,
        PageFactory $resultPageFactory,
        PaymentGatewayPoolInterface $paymentGatewayPool,
        PaytelligenceCardRepositoryInterface $cardRepository,
        CustomerHelper $customerHelper,
        Logger $logger,
        Config $config,
        PaytelligenceCardFactory $cardFactory
    ) {
        $this->request               = $request;
        $this->resultRedirectFactory = $redirectFactory;
        $this->messageManager        = $messageManager;
        $this->url                   = $url;
        $this->resultPageFactory     = $resultPageFactory;
        $this->paymentGatewayPool    = $paymentGatewayPool;
        $this->cardRepository        = $cardRepository;
        $this->customerHelper        = $customerHelper;
        $this->logger                = $logger;
        $this->config                = $config;
        $this->cardFactory           = $cardFactory;
    }

    /**
     * @return \Magento\Framework\App\RequestInterface
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Retrieve PaytelligenceCard by Id
     *
     * @param int $id
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface|null
     */
    protected function getCard(int $id)
    {
        $this->log('getCard()', ['id' => $id]);

        try {
            return $this->cardRepository->getById($id);
        } catch (Exception $e) {
            $this->log('getCard()', ['exception' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface|null
     */
    protected function getPaymentGateway(string $name)
    {
        $this->log('getPaymentGateway()', ['name' => $name]);

        try {
            return $this->paymentGatewayPool->getPaymentGateway($name);
        } catch (LocalizedException $e) {
            $this->log('getPaymentGateway()', [
                'name'      => $name,
                'exception' => $e->getMessage()
            ]);
        }

        return null;
    }

    /**
     * Write to extension log
     *
     * @param string $message
     * @param array  $extra
     */
    protected function log(string $message, array $extra = [])
    {
        $this->logger->info('Controller/Card - ' . $message, $extra);
    }
}
