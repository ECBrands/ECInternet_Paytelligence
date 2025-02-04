<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Controller\Card;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface;
use ECInternet\Paytelligence\Controller\Card;
use ECInternet\Paytelligence\Model\PaytelligenceCard;

/**
 * Delete Card Controller
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Delete extends Card implements HttpGetActionInterface
{
    /**
     * Execute 'Delete' action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $this->log('execute()');

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            $this->log('execute()', ['id' => $id]);

            if (is_numeric($id)) {
                /** @var \ECInternet\Paytelligence\Model\PaytelligenceCard $card */
                if ($card = $this->getCard((int)$id)) {
                    if ($this->doesCardBelongToCurrentCustomer($card)) {
                        try {
                            // Mark card as deleted
                            $this->markAsDeleted($card);

                            // Add message to screen
                            $this->messageManager->addSuccessMessage(
                                __('The Card has been deleted.')
                            );

                            // Redirect to homepage
                            return $resultRedirect->setPath('*/*/');
                        } catch (CouldNotSaveException $e) {
                            $this->log('execute()', ['exception' => $e->getMessage()]);

                            $this->messageManager->addErrorMessage(
                                __('Unable to delete Card.')
                            );

                            return $resultRedirect->setPath('*/*/');
                        }
                    } else {
                        $this->log('execute() - Card does not belong to current customer');
                    }
                } else {
                    $this->log('execute() - Could not find card with Id [' . $id . ']');
                }
            } else {
                $this->log('execute() - Value [' . $id . '] is not an int');
            }
        }

        $this->messageManager->addErrorMessage(
            __('Unable to delete Card.')
        );

        return $resultRedirect->setPath('*/*/');
    }

    private function doesCardBelongToCurrentCustomer(PaytelligenceCardInterface $card)
    {
        // Cache card customer
        $customer = $card->getCustomer();

        // Test for missing card CUSTOMER value
        if (empty($customer)) {
            return false;
        }

        // Test for current customer
        $currentCustomer = $this->customerHelper->getCurrentCustomer();
        if (!$currentCustomer) {
            return false;
        }

        /** @var string[] $customerNumbers */
        $customerNumbers = $this->customerHelper->getCustomerNumbers($currentCustomer);

        return in_array($customer, $customerNumbers);
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
        $this->logger->info('Controller/Card/Delete - ' . $message, $extra);
    }
}
