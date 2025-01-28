<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class PaytelligenceLogType implements OptionSourceInterface
{
    private const LOG_TYPE_REQUEST  = 'request';

    private const LOG_TYPE_RESPONSE = 'response';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];

        foreach ($this->getOptions() as $value => $label) {
            $result[] = [
                'value' => $value,
                'label' => $label,
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            self::LOG_TYPE_REQUEST  => __('Request'),
            self::LOG_TYPE_RESPONSE => __('Response')
        ];
    }
}
