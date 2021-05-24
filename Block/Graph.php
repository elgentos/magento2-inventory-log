<?php declare(strict_types=1);

namespace Elgentos\InventoryLog\Block;

use Elgentos\InventoryLog\Model\ResourceModel\Movement\Collection as MovementCollection;
use Elgentos\InventoryLog\Model\ResourceModel\Movement\CollectionFactory as MovementCollectionFactory;
use Magento\Backend\Block\Context;
use Magento\Catalog\Model\ProductRepository;

class Graph extends \Magento\Backend\Block\Template {
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        ProductRepository $productRepository,
        MovementCollectionFactory $movementCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->movementCollectionFactory = $movementCollectionFactory;
        $this->productId = $this->getRequest()->getParam('product_id') ?? $this->getRequest()->getParam('id');
    }

    public function getStockMovements()
    {
        /** @var MovementCollection $movementCollection */
        $movementCollection = $this->movementCollectionFactory->create();
        $movementCollection->addFieldToFilter('product_id', $this->productId);
        $movementCollection->setOrder('created_at', 'DESC');
        $movementCollection->setPageSize($this->getPageSize())->setCurPage($this->getCurPage());
        return $movementCollection;
    }

    public function getChartData()
    {
        return $this->getStockMovements()->getColumnValues('current_qty');
    }

    public function getLabels()
    {
        return array_map(function ($label) {
            return "'" . $label . "'";
        }, $this->getStockMovements()->getColumnValues('created_at'));
    }

    public function getProduct()
    {
        return $this->productRepository->getById($this->productId);
    }

    private function getPageSize()
    {
        return $this->getRequest()->getParam('page_size') ?? 100;
    }

    private function getCurPage()
    {
        return $this->getRequest()->getParam('p') ?? 1;
    }
}