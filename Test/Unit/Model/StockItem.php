<?php

namespace Elgentos\InventoryLog\Test\Unit\Model;

use Magento\CatalogInventory\Api\Data\StockItemInterface;

/**
 * Stock item with inventory movement data.
 */
interface StockItem extends StockItemInterface
{
    /**
     * Get the quantity before the movement.
     *
     * @return float|null
     */
    public function getOldQty();

    /**
     * Get the movement correlation key.
     *
     * @return string|null
     */
    public function getUkey();
}
