<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Controller;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface;
use ECInternet\Paytelligence\Logger\Logger;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory as CardCollectionFactory;
use Exception;

/**
 * Base Index controller
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
abstract class Index
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

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
     * @param \Magento\Framework\App\RequestInterface                                           $request
     * @param \Magento\Framework\Controller\Result\JsonFactory                                  $jsonFactory
     * @param \ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface                $cardRepository
     * @param \ECInternet\Paytelligence\Logger\Logger                                           $logger
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory $cardCollectionFactory
     */
    public function __construct(
        RequestInterface $request,
        JsonFactory $jsonFactory,
        PaytelligenceCardRepositoryInterface $cardRepository,
        Logger $logger,
        CardCollectionFactory $cardCollectionFactory
    ) {
        $this->request               = $request;
        $this->resultJsonFactory     = $jsonFactory;
        $this->cardRepository        = $cardRepository;
        $this->logger                = $logger;
        $this->cardCollectionFactory = $cardCollectionFactory;
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
            $this->log("getCard() - Card lookup failed - {$e->getMessage()}");
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
