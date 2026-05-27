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
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory as CardCollectionFactory;
use Exception;
use Psr\Log\LoggerInterface;

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
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory
     */
    protected $cardCollectionFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\RequestInterface                                           $request
     * @param \Magento\Framework\Controller\Result\JsonFactory                                  $jsonFactory
     * @param \ECInternet\Paytelligence\Api\PaytelligenceCardRepositoryInterface                $cardRepository
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory $cardCollectionFactory
     * @param \Psr\Log\LoggerInterface                                                          $logger
     */
    public function __construct(
        RequestInterface $request,
        JsonFactory $jsonFactory,
        PaytelligenceCardRepositoryInterface $cardRepository,
        CardCollectionFactory $cardCollectionFactory,
        LoggerInterface $logger
    ) {
        $this->request               = $request;
        $this->resultJsonFactory     = $jsonFactory;
        $this->cardRepository        = $cardRepository;
        $this->cardCollectionFactory = $cardCollectionFactory;
        $this->logger                = $logger;
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
            $this->log('getCard()', ['exception' => $e]);
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
        $this->logger->info('[ECInternet_Paytelligence] Controller/Index - ' . $message, $extra);
    }
}
