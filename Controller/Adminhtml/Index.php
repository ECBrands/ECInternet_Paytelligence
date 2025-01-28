<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;
use ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface;
use ECInternet\Paytelligence\Logger\Logger;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory as CardCollectionFactory;
use Exception;

/**
 * Abstract Adminhtml Index controller
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
abstract class Index extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface
     */
    protected $cardRepository;

    /**
     * @var \ECInternet\Paytelligence\Logger\Logger
     */
    protected $logger;

    /**
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory
     */
    protected $cardCollectionFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Backend\App\Action\Context                                               $context
     * @param \Magento\Framework\Controller\Result\JsonFactory                                  $jsonFactory
     * @param \Magento\Framework\View\Result\PageFactory                                        $resultPageFactory
     * @param \ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface                $cardRepository
     * @param \ECInternet\Paytelligence\Logger\Logger                                           $logger
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory $cardCollectionFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        PageFactory $resultPageFactory,
        PaytelligenceCardRepositoryInterface $cardRepository,
        Logger $logger,
        CardCollectionFactory $cardCollectionFactory
    ) {
        parent::__construct($context);

        $this->resultJsonFactory     = $jsonFactory;
        $this->resultPageFactory     = $resultPageFactory;
        $this->cardRepository        = $cardRepository;
        $this->logger                = $logger;
        $this->cardCollectionFactory = $cardCollectionFactory;
    }

    /**
     * Get card
     *
     * @param int $cardId
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface|null
     */
    protected function getCard(int $cardId)
    {
        try {
            return $this->cardRepository->getById($cardId);
        } catch (Exception $e) {
            $this->log('getCard()', ['exception' => $e->getMessage()]);
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
        $this->logger->info('Controller/Adminhtml/Index - ' . $message, $extra);
    }
}
