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
 * Card Edit Controller
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Edit extends Card implements HttpGetActionInterface
{
    /**
     * Execute 'Edit' action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $this->log('execute()', ['id' => $id]);

            if (is_numeric($id)) {
                $card = $this->getCard((int)$id);
                if (!$card || !$card->getId()) {
                    $this->messageManager->addErrorMessage(__('This card no longer exists.'));

                    return $this->resultRedirectFactory->create()->setPath('*/*/');
                }
            }
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Card'));

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
                'title' => __('My Cards'),
                'link'  => '/paytelligence/card/index'
            ]);
        }

        return $resultPage;
    }
}
