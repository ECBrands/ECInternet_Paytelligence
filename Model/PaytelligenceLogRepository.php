<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use ECInternet\Paytelligence\Api\Data\PaytelligenceLogInterface;
use ECInternet\Paytelligence\Api\PaytelligenceLogRepositoryInterface;
use ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceLog;
use Exception;

class PaytelligenceLogRepository implements PaytelligenceLogRepositoryInterface
{
    /**
     * @var \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceLog
     */
    private $_resourceModel;

    /**
     * PaytelligenceLogRepository constructor.
     *
     * @param \ECInternet\Paytelligence\Model\ResourceModel\PaytelligenceLog $resourceModel
     */
    public function __construct(
        PaytelligenceLog $resourceModel
    ) {
        $this->_resourceModel = $resourceModel;
    }

    /**
     * Save Log
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceLogInterface $log
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceLogInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(PaytelligenceLogInterface $log)
    {
        try {
            $this->_resourceModel->save($log);
        } catch (Exception $e) {
            if ($log->getId()) {
                throw new CouldNotSaveException(
                    __('Unable to save PaytelligenceLog with ID %1. Error: %2', [$log->getId(), $e->getMessage()])
                );
            }

            throw new CouldNotSaveException(__('Unable to save new PaytelligenceLog. Error: %1', $e->getMessage()));
        }

        return $log;
    }
}
