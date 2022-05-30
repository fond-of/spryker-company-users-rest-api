<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepository;
use Spryker\Zed\Kernel\Container;

class CompanyUsersRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiBusinessFactory
     */
    protected $companyUsersRestApiBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepository
     */
    protected $companyUsersRestApiRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface
     */
    protected $companyFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
     */
    protected $companyUserFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $companyUsersRestApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor
     */
    protected $companyUserPluginExecutorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
     */
    protected $companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $permissionFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUsersRestApiRepositoryMock = $this->getMockBuilder(CompanyUsersRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerFacadeInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->companyUsersRestApiConfigMock = $this->getMockBuilder(CompanyUsersRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserPluginExecutorMock = $this->getMockBuilder(CompanyUserPluginExecutor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiBusinessFactory = new CompanyUsersRestApiBusinessFactory();
        $this->companyUsersRestApiBusinessFactory->setRepository($this->companyUsersRestApiRepositoryMock);
        $this->companyUsersRestApiBusinessFactory->setConfig($this->companyUsersRestApiConfigMock);
        $this->companyUsersRestApiBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserReader(): void
    {
        $this->assertInstanceOf(
            CompanyUserReaderInterface::class,
            $this->companyUsersRestApiBusinessFactory->createCompanyUserReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserWriter(): void
    {
        $plugins = new \ArrayObject();

        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyUsersRestApiDependencyProvider::FACADE_CUSTOMER],
                [CompanyUsersRestApiDependencyProvider::FACADE_CUSTOMER],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER],
                [CompanyUsersRestApiDependencyProvider::FACADE_PERMISSION],
                [CompanyUsersRestApiDependencyProvider::PLUGIN_COMPANY_USER_POST_CREATE],
            )->willReturnOnConsecutiveCalls(
                $this->customerFacadeInterfaceMock,
                $this->customerFacadeInterfaceMock,
                $this->companyFacadeInterfaceMock,
                $this->companyBusinessUnitFacadeInterfaceMock,
                $this->companyUserFacadeInterfaceMock,
                $this->permissionFacadeMock,
                $plugins,
            );

        $this->assertInstanceOf(
            CompanyUserWriter::class,
            $this->companyUsersRestApiBusinessFactory->createCompanyUserWriter(),
        );
    }
}
