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
namespace Elgentos\InventoryLog\Test\Unit\Model;

use Elgentos\InventoryLog\Model\MovementFactory;
use Elgentos\InventoryLog\Api\Data\MovementInterfaceFactory;
use Elgentos\InventoryLog\Model\ResourceModel\Movement\CollectionFactory;
use Elgentos\InventoryLog\Api\Data\MovementSearchResultsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Elgentos\InventoryLog\Helper\Data as MovementHelper;
use Magento\Store\Api\Data\StoreInterface;
use Elgentos\InventoryLog\Model\Movement;
use Elgentos\InventoryLog\Api\Data\MovementInterface;
use Elgentos\InventoryLog\Api\Data\MovementSearchResultsInterface;
use Elgentos\InventoryLog\Model\ResourceModel\Movement\Collection;
use Magento\Framework\App\ProductMetadataInterface;
use Elgentos\InventoryLog\Model\MovementRepository;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Elgentos\InventoryLog\Model\ResourceModel\Movement as MovementResource;

/**
 * Test for Elgentos\InventoryLog\Model\MovementRepository
 */
class MovementRepositoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Elgentos\InventoryLog\Model\ResourceModel\Movement
     */
    public $movementResource;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Api\DataObjectHelper
     */
    public $dataHelper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Reflection\DataObjectProcessor
     */
    public $dataObjectProcessor;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Store\Model\StoreManagerInterface
     */
    public $storeManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Elgentos\InventoryLog\Helper\Data
     */
    public $movementDataHelper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Elgentos\InventoryLog\Model\Movement
     */
    public $movement;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Elgentos\InventoryLog\Api\Data\MovementInterface
     */
    public $movementData;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Elgentos\InventoryLog\Model\ResourceModel\Movement\CollectionFactory
     */
    public $collectionFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Elgentos\InventoryLog\Api\Data\MovementSearchResultsInterface
     */
    public $movementSearchResult;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Elgentos\InventoryLog\Model\ResourceModel\Movement\Collection
     */
    public $collection;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\CatalogInventory\Api\Data\StockItemInterface
     */
    public $stockItemMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Elgentos\InventoryLog\Model\MovementFactory
     */
    public $movementFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\App\ProductMetadataInterface
     */
    public $productMetadataMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Elgentos\InventoryLog\Model\MovementRepository
     */
    public $repository;

    /**
     * Initialize repository
     */
    protected function setUp(): void
    {
        $this->movementResource = $this->createStub(MovementResource::class);

        $this->movementFactory = $this->createStub(MovementFactory::class);

        $movementDataFactory = $this->createStub(MovementInterfaceFactory::class);

        $collectionFactory = $this->createStub(CollectionFactory::class);

        $movementSearchResultsInterfaceFactory = $this->createStub(MovementSearchResultsInterfaceFactory::class);

        $this->dataHelper = $this->createStub(DataObjectHelper::class);

        $this->dataObjectProcessor = $this->createStub(DataObjectProcessor::class);

        $this->storeManager = $this->createStub(StoreManagerInterface::class);

        $this->movementDataHelper = $this->createStub(MovementHelper::class);

        $store = $this->createStub(StoreInterface::class);
        $store->method('getId')->willReturn(0);
        $this->storeManager->method('getStore')->willReturn($store);

        $this->movement = $this->createStub(Movement::class);

        $this->movementData = $this->createStub(MovementInterface::class);

        $this->stockItemMock = $this->createStub(StockItem::class);

        $this->movementSearchResult = $this->createStub(MovementSearchResultsInterface::class);

        $this->collection = $this->createStub(Collection::class);

        $this->movementFactory
            ->method('create')
            ->willReturn($this->movement);

        $movementDataFactory
            ->method('create')
            ->willReturn($this->movementData);

        $collectionFactory
            ->method('create')
            ->willReturn($this->collection);

        $movementSearchResultsInterfaceFactory
            ->method('create')
            ->willReturn($this->movementSearchResult);

        $this->productMetadataMock = $this->createStub(ProductMetadataInterface::class);

        $this->repository = new MovementRepository(
            $this->movementResource,
            $this->movementFactory,
            $movementDataFactory,
            $collectionFactory,
            $movementSearchResultsInterfaceFactory,
            $this->dataHelper,
            $this->dataObjectProcessor,
            $this->storeManager,
            $this->movementDataHelper,
            $this->productMetadataMock,
            $this->createStub(CollectionProcessorInterface::class)
        );
    }

    public function testSave()
    {
        $this->movementResource = $this->createMock(MovementResource::class);
        $this->repository->resource = $this->movementResource;
        $this->movementResource->expects($this->once())
            ->method('save')
            ->with($this->movement)
            ->willReturnSelf();
        $this->assertEquals($this->movement, $this->repository->save($this->movement));
    }

    public function testDeleteById()
    {
        $this->movementResource = $this->createMock(MovementResource::class);
        $this->repository->resource = $this->movementResource;
        $movementId = '123';

        $this->movement
            ->method('getId')
            ->willReturn(true);
        $this->movementResource->expects($this->once())
            ->method('load')
            ->with($this->movement, $movementId)
            ->willReturnSelf();
        $this->movementResource->expects($this->once())
            ->method('delete')
            ->with($this->movement)
            ->willReturnSelf();

        $this->assertTrue($this->repository->deleteById($movementId));
    }

    public function testSaveException()
    {
        $this->movementResource = $this->createMock(MovementResource::class);
        $this->repository->resource = $this->movementResource;
        $this->expectException(CouldNotSaveException::class);
        $this->movementResource->expects($this->once())
            ->method('save')
            ->with($this->movement)
            ->willThrowException(new \Exception());
        $this->repository->save($this->movement);
    }

    public function testDeleteException()
    {
        $this->movementResource = $this->createMock(MovementResource::class);
        $this->repository->resource = $this->movementResource;
        $this->expectException(CouldNotDeleteException::class);
        $this->movementResource->expects($this->once())
            ->method('delete')
            ->with($this->movement)
            ->willThrowException(new \Exception());
        $this->repository->delete($this->movement);
    }

    public function testGetByIdException()
    {
        $this->movementResource = $this->createMock(MovementResource::class);
        $this->repository->resource = $this->movementResource;
        $this->expectException(NoSuchEntityException::class);
        $movementId = '123';

        $this->movement
            ->method('getId')
            ->willReturn(false);
        $this->movementResource->expects($this->once())
            ->method('load')
            ->with($this->movement, $movementId)
            ->willReturnSelf();
        $this->repository->getById($movementId);
    }

    public function testInsertStockMovement()
    {
        $message = 'Mock Test';
        $isNew = 0;
        $this->assertNull($this->repository->insertStockMovement($this->stockItemMock, $message, $isNew));
    }

    public function testInsertStockMovementWithData()
    {
        $this->movementResource = $this->createMock(MovementResource::class);
        $this->repository->resource = $this->movementResource;
        $itemId = '10';
        $productId = '15';
        $isInStock = 1;
        $uKey = 'AB454CD';
        $qty = 100;
        $oldQty = 10;
        $message = 'Mock Test';
        $isNew = 0;

        $this->movementResource->expects($this->once())->method('save')->with($this->movement);
        $this->movementDataHelper
            ->method('isModuleEnabled')
            ->willReturn(true);

        $this->stockItemMock->method('getOldQty')->willReturn($oldQty);
        $this->stockItemMock->method('getQty')->willReturn($qty);
        $this->stockItemMock->method('getItemId')->willReturn($itemId);
        $this->stockItemMock->method('getProductId')->willReturn($productId);
        $this->stockItemMock->method('getIsInStock')->willReturn($isInStock);
        $this->stockItemMock->method('getUkey')->willReturn($uKey);

        $this->assertEquals(
            $this->repository,
            $this->repository->insertStockMovement($this->stockItemMock, $message, $isNew)
        );
    }
}
