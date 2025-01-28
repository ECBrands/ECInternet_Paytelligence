<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api;

use ECInternet\Paytelligence\Api\Data\PaytelligenceLogInterface;

interface PaytelligenceLogRepositoryInterface
{
    /**
     * Save Log
     *
     * @param \ECInternet\Paytelligence\Api\Data\PaytelligenceLogInterface $log
     *
     * @return \ECInternet\Paytelligence\Api\Data\PaytelligenceLogInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(PaytelligenceLogInterface $log);
}
