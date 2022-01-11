<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserPermissionPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\RestCompanyRoleTransfer;
use Generated\Shared\Transfer\RestCompanyTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Spryker\Service\UtilText\UtilTextServiceInterface;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

class CompanyUserWriterTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter
     */
    protected $companyUserWriter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected $customerFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface
     */
    protected $restCustomerToCustomerMapperInterfaceMock;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface
     */
    protected $restCompanyUserToCompanyUserMapperInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface
     */
    protected $restApiErrorInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface
     */
    protected $companyUserReaderInterfaceMock;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerTransfer
     */
    protected $restCustomerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyRoleTransfer
     */
    protected $restCompanyRoleTransferMock;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected $companyRoleResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

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
     * @var \Generated\Shared\Transfer\RestCustomerTransfer|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $currentRestCustomerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $currentCompanyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyTransfer|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerFacadeInterfaceMock = $this->getMockBuilder(CustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerToCustomerMapperInterfaceMock = $this->getMockBuilder(RestCustomerToCustomerMapperInterface::class)
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

        $this->restCompanyUserToCompanyUserMapperInterfaceMock = $this->getMockBuilder(RestCompanyUserToCompanyUserMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiErrorInterfaceMock = $this->getMockBuilder(RestApiErrorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReaderInterfaceMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
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

        $this->currentRestCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyRoleTransferMock = $this->getMockBuilder(RestCompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->uuid = 'uuid';

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
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

        $this->customerNotFoundExceptionMock = $this->getMockBuilder(CustomerNotFoundException::class)
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
            $this->customerFacadeInterfaceMock,
            $this->restCustomerToCustomerMapperInterfaceMock,
            $this->companyFacadeInterfaceMock,
            $this->companyBusinessUnitFacadeInterfaceMock,
            $this->companyUserFacadeInterfaceMock,
            $this->restCompanyUserToCompanyUserMapperInterfaceMock,
            $this->restApiErrorInterfaceMock,
            $this->companyUserReaderInterfaceMock,
            $this->utilTextServiceInterfaceMock,
            $this->companyUsersRestApiConfigMock,
            $this->mailFacadeInterfaceMock,
            $this->companyRoleFacadeInterfaceMock,
            $this->permissionFacadeMock
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

        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
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

        $this->companyUserReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerToCustomerMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerToCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->restCompanyRoleTransferMock);

        $this->restCompanyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyRoleFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->restCompanyUserToCompanyUserMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCompanyUserToCompanyUser')
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

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyRoleCollection')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserReaderInterfaceMock->expects($this->atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(false);

        $this->companyUserFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
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

        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
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
                $this->restCompanyUsersRequestAttributesTransferMock
            )
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

        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
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

        $this->companyUserReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn(null);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testCreateCustomerNew(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
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

        $this->companyUserReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerToCustomerMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerToCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willThrowException($this->customerNotFoundExceptionMock);

        $this->utilTextServiceInterfaceMock->expects($this->atLeastOnce())
            ->method('generateRandomString')
            ->willReturn($this->randomString);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setPassword')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setRestorePasswordDate')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setRestorePasswordKey')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getRestorePasswordKey')
            ->willReturn($this->restorePasswordKey);

        $this->companyUsersRestApiConfigMock->expects($this->atLeastOnce())
            ->method('getCompanyUserPasswordRestoreTokenUrl')
            ->willReturn($this->companyUserPasswordRestoreTokenUrl);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setRestorePasswordLink')
            ->willReturn($this->customerTransferMock);

        $this->companyUserFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getLocale')
            ->willReturn($this->localeTransferMock);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('addCustomer')
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->customerResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCustomerTransfer')
            ->willReturn($this->customerTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testCreateCustomerCustomerTranfserNull(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
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

        $this->companyUserReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerToCustomerMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerToCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willThrowException($this->customerNotFoundExceptionMock);

        $this->utilTextServiceInterfaceMock->expects($this->atLeastOnce())
            ->method('generateRandomString')
            ->willReturn($this->randomString);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setPassword')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setRestorePasswordDate')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setRestorePasswordKey')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getRestorePasswordKey')
            ->willReturn($this->restorePasswordKey);

        $this->companyUsersRestApiConfigMock->expects($this->atLeastOnce())
            ->method('getCompanyUserPasswordRestoreTokenUrl')
            ->willReturn($this->companyUserPasswordRestoreTokenUrl);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setRestorePasswordLink')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('addCustomer')
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(false);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testCreateDefaultCompanyRoleNotFoundError(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
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

        $this->companyUserReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerToCustomerMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerToCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->restCompanyRoleTransferMock);

        $this->restCompanyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyRoleFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyIdNotMatch(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompanyString);

        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
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

        $this->companyUserReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerToCustomerMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerToCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->restCompanyRoleTransferMock);

        $this->restCompanyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyRoleFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
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

        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
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

        $this->companyUserReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerToCustomerMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerToCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->restCompanyRoleTransferMock);

        $this->restCompanyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyRoleFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->restCompanyUserToCompanyUserMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCompanyUserToCompanyUser')
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

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyRoleCollection')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserReaderInterfaceMock->expects($this->atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(true);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
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

        $this->companyFacadeInterfaceMock->expects($this->atLeastOnce())
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

        $this->companyUserReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerToCustomerMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCustomerToCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->restCompanyRoleTransferMock);

        $this->restCompanyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyRoleFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->idCompany);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->restCompanyUserToCompanyUserMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestCompanyUserToCompanyUser')
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

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyRoleCollection')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserReaderInterfaceMock->expects($this->atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(false);

        $this->companyUserFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testDisableCompanyUser(): void
    {
        $this->companyUserFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('disableCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserWriter->disableCompanyUser($this->companyUserTransferMock)
        );
    }
}
