<?php
/**
 * KiwiCommerce
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customise this module for your needs.
 * Please contact us https://kiwicommerce.co.uk/contacts.
 *
 * @category   KiwiCommerce
 * @package    Elgentos_InventoryLog
 * @copyright  Copyright (C) 2018 KiwiCommerce Ltd (https://kiwicommerce.co.uk/)
 * @license    https://kiwicommerce.co.uk/magento2-extension-license/
 */
namespace Elgentos\InventoryLog\Test\Unit\Model\ResourceModel;

use Elgentos\InventoryLog\Model\ResourceModel\Movement as MovementResourceModel;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Select;
use PHPUnit\Framework\TestCase;

class MovementTest extends TestCase
{
    /**
     * Read stock quantity by item ID.
     */
    public function testGetStockQty()
    {
        $this->assertStockQuantity('getStockQty', 'item_id = ?');
    }

    /**
     * Read stock quantity by product ID.
     */
    public function testGetStockItemByProduct()
    {
        $this->assertStockQuantity('getStockItemByProduct', 'product_id = ?');
    }

    /**
     * Assert the stock lookup uses the requested ID and returns the database value.
     *
     * @param string $method
     * @param string $condition
     */
    private function assertStockQuantity($method, $condition)
    {
        $select = $this->createMock(Select::class);
        $select->expects($this->once())->method('from')
            ->with('cataloginventory_stock_item', 'qty')->willReturnSelf();
        $select->expects($this->once())->method('where')
            ->with($condition, 123)->willReturnSelf();

        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->expects($this->once())->method('select')->willReturn($select);
        $adapter->expects($this->once())->method('fetchOne')->with($select)->willReturn('12.0000');

        $resource = $this->getMockBuilder(MovementResourceModel::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getConnection', 'getTable'])
            ->getMock();
        $resource->expects($this->once())->method('getConnection')->willReturn($adapter);
        $resource->expects($this->exactly(2))->method('getTable')
            ->with('cataloginventory_stock_item')->willReturnArgument(0);

        $this->assertSame('12.0000', $resource->$method('123'));
    }
}
