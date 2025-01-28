<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */

/** @noinspection PhpArrayUsedOnlyForWriteInspection */
/** @noinspection PhpArrayWriteIsNotUsedInspection */
/** @noinspection PhpUnusedLocalVariableInspection */

declare(strict_types=1);

namespace ECInternet\Paytelligence\Controller\Card;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use ECInternet\Paytelligence\Controller\Card;
use Exception;

class Save extends Card implements HttpPostActionInterface
{
    /**
     * Execute 'Save' action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->log('execute()');

        $data = $this->getRequest()->getParams();
        if (!$data) {
            $this->log('execute() - No post values');

            $this->messageManager->addNoticeMessage(
                __('Card not updated. Form submission blank.')
            );

            return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
        }

        $this->log('execute()', ['params' => $data]);

        if (isset($data['entity_id'])) {
            if (empty($data['entity_id'])) {
                $this->messageManager->addErrorMessage(
                    __('Card not updated. Form submission incomplete - Unable to determine Card Id.')
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }

            // entity_id is not empty
            $cardId = $data['entity_id'];

            if (!is_numeric($cardId)) {
                $this->messageManager->addErrorMessage(
                    __("Card not updated. Non-numeric id found: [$cardId].")
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }

            /** @var \ECInternet\Paytelligence\Api\Data\PaytelligenceCardInterface $card */
            $card = $this->getCard((int)$cardId);
            if (!$card) {
                $this->messageManager->addNoticeMessage(
                    __("Card not updated. Unable to find PaytelligenceCard $cardId")
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }

            $creditCardNetwork = $card->getCreditCardNetwork();
            if (empty($creditCardNetwork)) {
                $this->messageManager->addNoticeMessage(
                    __('Card not updated. Card does not contain payment method information.')
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }

            $paymentGateway = $this->getPaymentGateway($creditCardNetwork);
            if ($paymentGateway === null) {
                $this->messageManager->addNoticeMessage(
                    __("Card not updated. Unable to find payment gateway '$creditCardNetwork'")
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }

            if (isset($data['expmonth'])) {
                $expMonth = $data['expmonth'];
                if (is_numeric($expMonth)) {
                    if ($expMonth !== $card->getExpiryMonth()) {
                        $card->setExpiryMonth($expMonth);
                    }
                }
            }

            if (isset($data['expyear'])) {
                $expYear = $data['expyear'];
                if (is_numeric($expYear)) {
                    if ($expYear !== $card->getExpiryYear()) {
                        $card->setExpiryYear($expYear);
                    }
                }
            }

            if (!empty($data['cvv'])) {
                $card->setData('cvv', $data['cvv']);
            }

            // Attempt payment gateway update
            try {
                $paymentGateway->updateVaultCard($card);
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Card not updated: ' . $e->getMessage())
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }

            // Attempt card update
            try {
                $this->cardRepository->save($card);
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage(
                    __("Card not updated: {$e->getMessage()}")
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }

            $this->messageManager->addSuccessMessage('Card updated.');
        } else {
            // Lookup Payment Gateway from setting
            $addCardPaymentGatewayName = $this->getAddCardPaymentGatewayName();
            $this->log('execute()', ['addCardPaymentGatewayName' => $addCardPaymentGatewayName]);

            if (!$addCardPaymentGatewayName) {
                $this->messageManager->addNoticeMessage(
                    __("Paytellignce not configured correctly. Please set 'addCardPaymentGateway' setting.")
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }

            /** @var \ECInternet\Paytelligence\Api\Data\PaymentGatewayInterface $addCardPaymentGateway */
            $addCardPaymentGateway = $this->getPaymentGateway($addCardPaymentGatewayName);
            if ($addCardPaymentGateway === null) {
                $this->messageManager->addNoticeMessage(
                    __("Card not updated. Unable to find payment gateway '" . $addCardPaymentGatewayName . "'")
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }

            // Make API call

            // Card may already exist, we shouldn't assume addVaultCard
            // paytelligence helper -> does card exist
            if ($this->isCardNew($data)) {
                $this->log('execute()', ['message' => 'Card is new' ]);

                try {
                    $response = $addCardPaymentGateway->addVaultCard($data);
                } catch (Exception $e) {
                    $this->messageManager->addErrorMessage(
                        __("Card not added: {$e->getMessage()}")
                    );

                    return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
                }

                // Persist to DB
                try {
                    $card = $addCardPaymentGateway->saveCard($data, $response);
                } catch (Exception $e) {
                    $this->messageManager->addErrorMessage(
                        __('Unable to add card to Magento: ' . $e->getMessage())
                    );

                    return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
                }

                $this->messageManager->addSuccessMessage('Card added.');
            } else {
                $this->messageManager->addNoticeMessage(
                    __('Card not added. Card already exists.')
                );

                return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
            }
        }

        return $this->resultRedirectFactory->create()->setPath('paytelligence/card/index');
    }

    protected function getAddCardPaymentGatewayName()
    {
        return $this->helper->getAddCardPaymentGateway();
    }

    protected function isCardNew($data)
    {
        $this->log('isCardNew()');

        if (!isset($data['cardnumber'])) {
            $this->log('isCardNew()', ['message' => 'No card number found in data']);
            return false;
        }

        if (strlen($data['cardnumber']) < 4) {
            $this->log('isCardNew()', ['message' => 'Card number is less than 4 characters']);
            return false;
        }

        if (!isset($data['expmonth'])) {
            $this->log('isCardNew()', ['message' => 'No expiry month found in data']);
            return false;
        }

        if (!is_numeric($data['expmonth'])) {
            $this->log('isCardNew()', ['message' => 'Expiry month is not numeric']);
            return false;
        }

        if (!isset($data['expyear'])) {
            $this->log('isCardNew()', ['message' => 'No expiry year found in data']);
            return false;
        }

        if (!is_numeric($data['expyear'])) {
            $this->log('isCardNew()', ['message' => 'Expiry year is not numeric']);
            return false;
        }

        $lastFour   = substr($data['cardnumber'], -4);
        $expMonth   = $data['expmonth'];
        $expYear    = $data['expyear'];

        if ($customer = $this->customerHelper->getCurrentCustomer()) {
            $customerNumbers = $this->customerHelper->getCustomerNumbers($customer);

            return $this->helper->isNewCard($lastFour, $customerNumbers, (int)$expMonth, (int)$expYear);
        }

        return true;
    }

    protected function log($message, $extra = [])
    {
        $this->logger->info('Controller/Card/Save - ' . $message, $extra);
    }
}
