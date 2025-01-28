<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use ECInternet\Paytelligence\Controller\Adminhtml\Index;
use ECInternet\Paytelligence\Model\PaytelligenceCard;

/**
 * Adminhtml Delete controller
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Delete extends Index implements HttpPostActionInterface
{
    /**
     * Execute 'Delete' action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            /** @var \ECInternet\Paytelligence\Model\PaytelligenceCard $card */
            $card = $this->getCard($id);
            if ($card) {
                try {
                    // Delete card
                    $this->markAsDeleted($card);

                    // Add message to screen
                    $this->messageManager->addSuccessMessage('The Card has been deleted.');

                    // Redirect to homepage
                    return $resultRedirect->setPath('*/*/');
                } catch (CouldNotSaveException $e) {
                    $this->log('execute()', [
                        'exception' => $e->getMessage(),
                        'trace'     => $e->getTraceAsString()
                    ]);

                    $this->messageManager->addErrorMessage('Unable to delete Card.');

                    return $resultRedirect->setPath('*/*/');
                }
            }
        }

        $this->messageManager->addErrorMessage('Unable to find Card.');

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Delete card
     *
     * @param \ECInternet\Paytelligence\Model\PaytelligenceCard $card
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    private function markAsDeleted(
        PaytelligenceCard $card
    ) {
        $this->log('markAsDeleted()', ['cardId' => $card->getId()]);

        // Set card state to "DELETED"
        $card->setCardState(PaytelligenceCard::CARD_STATE_DELETED);

        // Save card
        $this->cardRepository->save($card);
    }

    /**
     * Write to extension log
     *
     * @param string $message
     * @param array  $extra
     */
    protected function log(string $message, array $extra = [])
    {
        $this->logger->info('Controller/Adminhtml/Index/Delete - ' . $message, $extra);
    }
}
