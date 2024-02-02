<?php

namespace Elgentos\InventoryLog\Plugin\Webapi\Stock;

class StockItemRepository
{
    public function __construct(
        public \Magento\Framework\Registry $registry,
        public \Elgentos\InventoryLog\Helper\Data $helper
    ) {}

    public function beforeSave(
        $subject,
        \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem
    ): array {
        if (!$this->helper->isModuleEnabled()) {
            return [$stockItem];
        }

        $this->registry->register(
            \Elgentos\InventoryLog\Helper\Data::MOVEMENT_SECTION,
            \Elgentos\InventoryLog\Helper\Data::WEBAPI_STOCK_UPDATE
        );

        return [$stockItem];
    }
}
