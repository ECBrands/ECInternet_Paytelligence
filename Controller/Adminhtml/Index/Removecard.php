<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use ECInternet\Paytelligence\Controller\Adminhtml\Index;
use ECInternet\Paytelligence\Model\PaytelligenceCard;
use Exception;

/**
 * Adminhtml Removecard Index Controller
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Removecard extends Index implements HttpPostActionInterface
{
    private const PROFILE_ID_PARAMETER = 'profil_id';

    /**
     * Execute 'Removecard' action - Update card state to 'Deleted'
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $this->log('execute()');

        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultJsonFactory->create();

        // Default to valid response
        $status = 1;

        $profileId = $this->getRequest()->getParam(self::PROFILE_ID_PARAMETER);
        $this->log('execute()', ['profileId' => $profileId]);

        if ($profileId) {
            /** @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceCard\Collection $cardCollection */
            $cardCollection = $this->cardCollectionFactory->create()
                ->addFieldToFilter(PaytelligenceCard::COLUMN_PROFILID, $profileId);
            $this->log("execute() - Found {$cardCollection->getSize()} PaytelligenceCards with ProfileID [$profileId].");

            foreach ($cardCollection->getItems() as $card) {
                /** @var \ECInternet\Paytelligence\Model\PaytelligenceCard $card */
                $card->setCardState(2);

                try {
                    $this->cardRepository->save($card);
                } catch (Exception $e) {
                    $this->log("EXCEPTION - Unable to save PaytelligenceCard {$card->getId()} - {$e->getMessage()}.");

                    $status = 0;
                }
            }
        }

        $result->setData(['status' => $status]);

        return $result;
    }

    /**
     * Write to extension log
     *
     * @param string $message
     * @param array  $extra
     */
    protected function log(string $message, array $extra = [])
    {
        $this->logger->info('Controller/Adminhtml/Index/Removecard - ' . $message, $extra);
    }
}
