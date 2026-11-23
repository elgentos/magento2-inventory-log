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
namespace Elgentos\InventoryLog\Test\Unit\Helper;

use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Backend\Model\Auth\Session as AdminSession;
use Magento\Framework\Registry;
use Magento\Framework\Authorization\PolicyInterface;

class DataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Event\ManagerInterface
     */
    public $eventManagerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\UrlInterface
     */
    public $urlBuilderMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\App\RequestInterface
     */
    public $httpRequestMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Customer\Model\Session
     */
    public $customerSessionMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Backend\Model\Auth\Session
     */
    public $adminSessionMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Registry
     */
    public $registryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Framework\Authorization\PolicyInterface
     */
    public $policyMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Backend\Model\Auth\Session
     */
    public $authSessionMock;

    /**
     * @var \Elgentos\InventoryLog\Helper\Data
     */
    public $object;

    /**
     * Initialize Data
     */
    protected function setUp(): void
    {
        $this->eventManagerMock = $this->createStub(ManagerInterface::class);

        $this->urlBuilderMock = $this->createStub(UrlInterface::class);

        $this->httpRequestMock = $this->createStub(RequestInterface::class);

        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $context = $objectManager->getObject(
            \Magento\Framework\App\Helper\Context::class,
            [
                'eventManager' => $this->eventManagerMock,
                'urlBuilder' => $this->urlBuilderMock,
                'httpRequest' => $this->httpRequestMock,
            ]
        );

        $this->customerSessionMock = $this->createStub(CustomerSession::class);

        $this->adminSessionMock = $this->createStub(AdminSession::class);

        $this->registryMock = $this->createStub(Registry::class);

        $this->policyMock = $this->createStub(PolicyInterface::class);

        $this->authSessionMock = $this->createStub(AdminSession::class);

        $this->object = $objectManager->getObject(
            \Elgentos\InventoryLog\Helper\Data::class,
            [
                'context' => $context,
                'customerSession' => $this->customerSessionMock,
                'backendAuthSession' => $this->adminSessionMock,
                'registry' => $this->registryMock,
                'policyInterface' => $this->policyMock,
                'authSession' => $this->authSessionMock
            ]
        );
    }

    public function testGenerateRandomString()
    {
        $length = 5;
        $expectedResult = 'uL8XL';
        $this->assertNotEquals($expectedResult, $this->object->generateRandomString($length));
    }
}
