<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use ECInternet\Paytelligence\Controller\Adminhtml\Index;

/**
 * Adminhtml RequestResponseLog Index Controller
 */
class RequestResponseLog extends Index implements HttpGetActionInterface
{
    /**
     * Execute 'RequestResponseLog' action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Paytelligence Request/Response Log'));

        return $resultPage;
    }
}
