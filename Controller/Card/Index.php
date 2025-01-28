<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Controller\Card;

use Magento\Framework\App\Action\HttpGetActionInterface;
use ECInternet\Paytelligence\Controller\Card;

/**
 * Card Controller
 */
class Index extends Card implements HttpGetActionInterface
{
    /**
     * Execute 'Index' action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('My Cards'));

        /** @var \Magento\Theme\Block\Html\Breadcrumbs $breadcrumbs */
        $breadcrumbs = $resultPage->getLayout()->getBlock('breadcrumbs');
        if ($breadcrumbs) {
            $breadcrumbs->addCrumb('home', [
                'label' => __('Home'),
                'title' => __('Home'),
                'link'  => $this->url->getUrl('')
            ]);
            $breadcrumbs->addCrumb('my_account', [
                'label' => __('My Account'),
                'title' => __('My Account'),
                'link'  => '/customer/account/'
            ]);
            $breadcrumbs->addCrumb('my_cards', [
                'label' => __('My Cards'),
                'title' => __('My Cards')
            ]);
        }

        return $resultPage;
    }
}
