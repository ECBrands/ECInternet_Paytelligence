<?php
/**
 * Copyright (C) EC Brands Corporation - All Rights Reserved
 * Contact Licensing@ECInternet.com for use guidelines
 */
declare(strict_types=1);

namespace ECInternet\Paytelligence\Test\Integration\Setup;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

class ExtensionInstallTest extends TestCase
{
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $resourceConnection;

    protected function setUp(): void
    {
        $objectManager            = Bootstrap::getObjectManager();
        $this->resourceConnection = $objectManager->get(ResourceConnection::class);
    }

    // -------------------------------------------------------------------------
    // Custom tables (db_schema.xml)
    // -------------------------------------------------------------------------

    public function testCardTableWasCreated(): void
    {
        $connection = $this->getConnection();
        $table      = $this->resourceConnection->getTableName('ecinternet_paytelligence_card');

        $this->assertTrue($connection->isTableExists($table), 'ecinternet_paytelligence_card table should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'entity_id'),  'card.entity_id column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'created_at'), 'card.created_at column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'updated_at'), 'card.updated_at column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'CARDID'),     'card.CARDID column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'CUSTOMER'),   'card.CUSTOMER column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'PROFILID'),   'card.PROFILID column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'CARDMASK'),   'card.CARDMASK column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'DFLTCARD'),   'card.DFLTCARD column should exist.');
    }

    public function testTransTableWasCreated(): void
    {
        $connection = $this->getConnection();
        $table      = $this->resourceConnection->getTableName('ecinternet_paytelligence_trans');

        $this->assertTrue($connection->isTableExists($table), 'ecinternet_paytelligence_trans table should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'entity_id'),            'trans.entity_id column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'created_at'),           'trans.created_at column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'updated_at'),           'trans.updated_at column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'TRNSNUM'),              'trans.TRNSNUM column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'CARDID'),               'trans.CARDID column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'CUSTOMER'),             'trans.CUSTOMER column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'increment_id'),         'trans.increment_id column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'order_id'),             'trans.order_id column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'parent_transaction_id'), 'trans.parent_transaction_id column should exist.');
    }

    public function testLogTableWasCreated(): void
    {
        $connection = $this->getConnection();
        $table      = $this->resourceConnection->getTableName('ecinternet_paytelligence_log');

        $this->assertTrue($connection->isTableExists($table), 'ecinternet_paytelligence_log table should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'entity_id'),       'log.entity_id column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'created_at'),      'log.created_at column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'updated_at'),      'log.updated_at column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'order_number'),    'log.order_number column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'payment_gateway'), 'log.payment_gateway column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'area_code'),       'log.area_code column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'log_type'),        'log.log_type column should exist.');
        $this->assertTrue($connection->tableColumnExists($table, 'value'),           'log.value column should exist.');
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function getConnection(): AdapterInterface
    {
        return $this->resourceConnection->getConnection();
    }
}
