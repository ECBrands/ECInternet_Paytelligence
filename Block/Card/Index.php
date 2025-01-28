<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Block\Card;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Theme\Block\Html\Pager;
use ECInternet\Paytelligence\Helper\Customer as CustomerHelper;
use ECInternet\Paytelligence\Helper\Data;
use ECInternet\Paytelligence\Logger\Logger;
use ECInternet\Paytelligence\Model\PaytelligenceCard;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory as CardCollectionFactory;

/**
 * Card Index Block
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Index extends Template
{
    /**
     * @var \ECInternet\Paytelligence\Helper\Customer
     */
    private $customerHelper;

    /**
     * @var \ECInternet\Paytelligence\Helper\Data
     */
    private $helper;

    /**
     * @var \ECInternet\Paytelligence\Logger\Logger
     */
    private $logger;

    /**
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory
     */
    private $cardCollectionFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context                                  $context
     * @param \ECInternet\Paytelligence\Helper\Customer                                         $customerHelper
     * @param \ECInternet\Paytelligence\Helper\Data                                             $helper
     * @param \ECInternet\Paytelligence\Logger\Logger                                           $logger
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\CollectionFactory $cardCollectionFactory
     * @param array                                                                             $data
     */
    public function __construct(
        Context $context,
        CustomerHelper $customerHelper,
        Data $helper,
        Logger $logger,
        CardCollectionFactory $cardCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->customerHelper        = $customerHelper;
        $this->helper                = $helper;
        $this->logger                = $logger;
        $this->cardCollectionFactory = $cardCollectionFactory;
    }

    /**
     * Prepare global layout
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if ($this->getCards()) {
            /** @var \Magento\Theme\Block\Html\Pager $pager */
            $pager = $this->getLayout()->createBlock(
                Pager::class,
                'paytelligence.card.index.pager'
            );

            $pager
                ->setAvailableLimit([10 => 10, 20 => 20])
                ->setShowPerPage(true)
                ->setCollection($this->getCards());

            $this->setChild('pager', $pager);
            $this->getCards()->load();
        }

        return $this;
    }

    /**
     * Get pager html
     *
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Get cards
     *
     * @return \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\Collection|bool
     */
    public function getCards()
    {
        $this->log('getCards()');

        if ($customer = $this->customerHelper->getCurrentCustomer()) {
            $customerNumbers = $this->helper->getCustomerNumbers($customer);
            $this->log('getCards()', ['customerNumbers' => $customerNumbers]);

            if ($customerNumbers) {
                // Get value of current page
                $page = ($this->getRequest()->getParam('p'))
                    ? $this->getRequest()->getParam('p')
                    : 1;

                // Get value of current limit
                $pageSize = ($this->getRequest()->getParam('limit'))
                    ? $this->getRequest()->getParam('limit')
                    : 10;

                $collection = $this->cardCollectionFactory->create()
                    ->addFieldToFilter(PaytelligenceCard::COLUMN_CUSTOMER, ['in' => implode(',', $customerNumbers)])
                    ->addFieldToFilter(PaytelligenceCard::COLUMN_ISSTORED, ['eq' => 1])
                    ->addFieldToFilter(PaytelligenceCard::COLUMN_CARDSTTE, ['eq' => 1])
                    ->setPageSize($pageSize)
                    ->setCurPage($page);

                $this->log('getCards()', [
                    'query' => $collection->getSelect(),
                    'count' => $collection->getSize()
                ]);

                return $collection;
            }
        }

        return false;
    }

    /**
     * Get 'Edit' url
     *
     * @param \ECInternet\Paytelligence\Model\PaytelligenceCard $card
     *
     * @return string
     */
    public function getEditUrl(PaytelligenceCard $card)
    {
        return $this->getUrl('paytelligence/card/edit', ['id' => $card->getId()]);
    }

    /**
     * Get 'Delete' url
     *
     * @param \ECInternet\Paytelligence\Model\PaytelligenceCard $card
     *
     * @return string
     */
    public function getDeleteUrl(PaytelligenceCard $card)
    {
        return $this->getUrl('paytelligence/card/delete', ['id' => $card->getId()]);
    }

    private function log(string $message, array $extra = [])
    {
        $this->logger->info('Block/Card/Index - ' . $message, $extra);
    }
}
