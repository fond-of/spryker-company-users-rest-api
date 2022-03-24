<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiEntityManager;
use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepository;
use Spryker\Service\UtilText\UtilTextServiceInterface;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected $customerFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected $companyFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected $companyUserFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Service\UtilText\UtilTextServiceInterface
     */
    protected $utilTextServiceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $companyUsersRestApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    protected $mailFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiEntityManager
     */
    protected $companyUsersRestApiEntityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
     */
    protected $companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
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

        $this->customerFacadeInterfaceMock = $this->getMockBuilder(CustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeInterfaceMock = $this->getMockBuilder(CompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeInterfaceMock = $this->getMockBuilder(CompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeInterfaceMock = $this->getMockBuilder(CompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->utilTextServiceInterfaceMock = $this->getMockBuilder(UtilTextServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiConfigMock = $this->getMockBuilder(CompanyUsersRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailFacadeInterfaceMock = $this->getMockBuilder(MailFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeInterfaceMock = $this->getMockBuilder(CompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiEntityManagerMock = $this->getMockBuilder(CompanyUsersRestApiEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiBusinessFactory = new CompanyUsersRestApiBusinessFactory();
        $this->companyUsersRestApiBusinessFactory->setEntityManager($this->companyUsersRestApiEntityManagerMock);
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
            $this->companyUsersRestApiBusinessFactory->createCompanyUserReader()
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserWriter(): void
    {
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
                [CompanyUsersRestApiDependencyProvider::SERVICE_UTIL_TEXT],
                [CompanyUsersRestApiDependencyProvider::FACADE_MAIL],
                [CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_ROLE],
                [CompanyUsersRestApiDependencyProvider::FACADE_PERMISSION]
            )->willReturnOnConsecutiveCalls(
                $this->customerFacadeInterfaceMock,
                $this->customerFacadeInterfaceMock,
                $this->companyFacadeInterfaceMock,
                $this->companyBusinessUnitFacadeInterfaceMock,
                $this->companyUserFacadeInterfaceMock,
                $this->utilTextServiceInterfaceMock,
                $this->mailFacadeInterfaceMock,
                $this->companyRoleFacadeInterfaceMock,
                $this->permissionFacadeMock
            );

        $this->assertInstanceOf(
            CompanyUserWriter::class,
            $this->companyUsersRestApiBusinessFactory->createCompanyUserWriter()
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserUnitAddressQuoteMapper(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE)
            ->willReturn($this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock);

        $this->assertInstanceOf(
            CompanyUserUnitAddressQuoteMapperInterface::class,
            $this->companyUsersRestApiBusinessFactory->createCompanyUserUnitAddressQuoteMapper()
        );
    }
}
