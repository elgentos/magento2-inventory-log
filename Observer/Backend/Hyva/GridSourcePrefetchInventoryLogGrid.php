<?php declare(strict_types=1);

namespace Elgentos\InventoryLog\Observer\Backend\Hyva;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

class GridSourcePrefetchInventoryLogGrid implements \Magento\Framework\Event\ObserverInterface
{
    private FilterBuilder $filterBuilder;

    private FilterGroupBuilder $filterGroupBuilder;

    private \Magento\Framework\Registry $registry;
    
    public function __construct(
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        \Magento\Framework\Registry $registry
    ) {
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->registry = $registry;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        if (!$this->registry->registry('current_product')) {
            return;
        }
        /** @var SearchCriteriaInterface $searchCriteria */
        $searchCriteria = $observer->getEvent()->getSearchCriteriaContainer()->getSearchCriteria();
        $filterGroups = $searchCriteria->getFilterGroups();
        $filters[] = $this->filterBuilder
            ->setField('product_id')
            ->setConditionType('eq')
            ->setValue($this->registry->registry('current_product')->getId())
            ->create();
        $filterGroups[] = $this->filterGroupBuilder->setFilters($filters)->create();
        $searchCriteria->setFilterGroups($filterGroups);
    }
}
