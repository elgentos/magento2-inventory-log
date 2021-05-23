<?php declare(strict_types=1);

namespace Elgentos\InventoryLog\HyvaGridProcessor;

use Hyva\Admin\Api\HyvaGridCollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\AbstractDb as AbstractDbCollection;

class MovementCollectionProcessor extends \Hyva\Admin\Model\GridSource\AbstractGridSourceProcessor implements HyvaGridCollectionProcessorInterface
{
    public function afterInitSelect(AbstractDbCollection $source, string $gridName): void
    {
        $source->join(['cpe' => 'catalog_product_entity'], 'cpe.entity_id = main_table.product_id', ['sku']);
    }
}