<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Model;

use Magento\Framework\Model\AbstractModel;
use ECInternet\Paytelligence\Api\Data\SetCardIdRequestInterface;

class SetCardIdRequest extends AbstractModel implements SetCardIdRequestInterface
{
    public function getId()
    {
        return $this->getData(self::COLUMN_ID);
    }

    public function getCardId()
    {
        return (int)$this->getData(self::COLUMN_CARDID);
    }

    public function setCardId(int $cardId)
    {
        $this->setData(self::COLUMN_CARDID, $cardId);
    }
}
