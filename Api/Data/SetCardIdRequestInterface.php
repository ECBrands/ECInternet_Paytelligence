<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Api\Data;

interface SetCardIdRequestInterface
{
    public const COLUMN_ID     = PaytelligenceCardInterface::COLUMN_ID;

    public const COLUMN_CARDID = PaytelligenceCardInterface::COLUMN_CARDID;

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return int
     */
    public function getCardId();

    /**
     * @param int $cardId
     *
     * @return void
     */
    public function setCardId(int $cardId);
}
