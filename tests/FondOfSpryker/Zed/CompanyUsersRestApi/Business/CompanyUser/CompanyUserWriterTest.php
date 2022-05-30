<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserPermissionPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\RestCompanyTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CompanyUserWriterTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter
     */
    protected $companyUserWriter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface
     */
    protected $customerMapperMock;

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
    protected $companyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface
     */
    protected $companyUserMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface
     */
    protected $restApiErrorInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface
     */
    protected $companyUserReaderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface
     */
    protected $utilTextServiceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $companyUsersRestApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var int
     */
    protected $idCompany;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected $restCompanyUsersResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerTransfer
     */
    protected $restCustomerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor
     */
    protected $companyUserPluginExecutorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var string
     */
    protected $idCompanyString;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException
     */
    protected $customerNotFoundExceptionMock;

    /**
     * @var string
     */
    protected $randomString;

    /**
     * @var string
     */
    protected $restorePasswordKey;

    /**
     * @var string
     */
    protected $companyUserPasswordRestoreTokenUrl;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\LocaleTransfer
     */
    protected $localeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestCustomerTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $currentRestCustomerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $currentCompanyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $restCompanyTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerMapperMock = $this->getMockBuilder(CustomerMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserMapperMock = $this->getMockBuilder(CompanyUserMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiErrorMock = $this->getMockBuilder(RestApiErrorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->utilTextServiceMock = $this->getMockBuilder(CompanyUsersRestApiToUtilTextServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiConfigMock = $this->getMockBuilder(CompanyUsersRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyTransferMock = $this->getMockBuilder(RestCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompanyString = 'id-company';

        $this->idCompany = 1;

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersResponseTransferMock = $this->getMockBuilder(RestCompanyUsersResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentRestCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->uuid = 'uuid';

        $this->companyUserPluginExecutorMock = $this->getMockBuilder(CompanyUserPluginExecutor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentCompanyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->randomString = 'random-string';

        $this->restorePasswordKey = 'restore-password-key';

        $this->companyUserPasswordRestoreTokenUrl = 'company-user-password-restore-token-url';

        $this->localeTransferMock = $this->getMockBuilder(LocaleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerResponseTransferMock = $this->getMockBuilder(CustomerResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserWriter = new CompanyUserWriter(
            $this->customerFacadeMock,
            $this->customerMapperMock,
            $this->companyFacadeMock,
            $this->companyBusinessUnitFacadeMock,
            $this->companyUserFacadeMock,
            $this->companyUserMapperMock,
            $this->restApiErrorMock,
            $this->companyUserReaderMock,
            $this->companyUsersRestApiConfigMock,
            $this->permissionFacadeMock,
            $this->companyUserPluginExecutorMock
        );
    }

    /**
     * @return void
     */
    public function testCreateWithCustomerRegistration(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyByUuid')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->customerMapperMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerTransferToCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willThrowException(new \Exception());

        $this->customerFacadeMock->expects($this->atLeastOnce())
            ->method('addCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->customerResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setIsNew')
            ->with(true)
            ->willReturnSelf();

        $this->companyUserMapperMock->expects($this->atLeastOnce())
            ->method('mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompany')
            ->with($this->companyTransferMock)
            ->willReturnSelf();

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCompany')
            ->willReturnSelf();

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyBusinessUnit')
            ->willReturnSelf();

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCompanyBusinessUnit')
            ->willReturnSelf();

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCustomer')
            ->willReturnSelf();

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCustomer')
            ->willReturnSelf();

        $this->companyUserReaderMock->expects($this->atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(false);

        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserPluginExecutorMock->expects($this->atLeastOnce())
            ->method('executePostCreatePlugins')
            ->with($this->companyUserTransferMock, $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyByUuid')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->customerMapperMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerTransferToCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyUserMapperMock->expects($this->atLeastOnce())
            ->method('mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserReaderMock->expects($this->atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(false);

        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserPluginExecutorMock->expects($this->atLeastOnce())
            ->method('executePostCreatePlugins')
            ->with($this->companyUserTransferMock, $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyNotFoundError(): void
    {
        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyByUuid')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitNull(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyByUuid')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn(null);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserAlreadyExists(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyByUuid')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->customerMapperMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerTransferToCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyUserMapperMock->expects($this->atLeastOnce())
            ->method('mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserReaderMock->expects($this->atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(true);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserResponseNotSuccessful(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeMock->expects($this->atLeastOnce())
            ->method('findCompanyByUuid')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->customerMapperMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerTransferToCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->companyUserMapperMock->expects($this->atLeastOnce())
            ->method('mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setFkCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserReaderMock->expects($this->atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(false);

        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDisableCompanyUser(): void
    {
        $this->companyUserFacadeMock->expects($this->atLeastOnce())
            ->method('disableCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserWriter->disableCompanyUser($this->companyUserTransferMock),
        );
    }
}
