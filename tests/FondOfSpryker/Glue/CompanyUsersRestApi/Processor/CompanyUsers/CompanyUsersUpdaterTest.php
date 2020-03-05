<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyRoleTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Client\CompanyRole\CompanyRoleClientInterface;
use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUsersUpdaterTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersUpdater
     */
    protected $companyUsersUpdater;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $companyUsersRestApiClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiErrorInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface
     */
    protected $companyUsersRestApiToCompanyUserClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface
     */
    protected $companyUsersRestApiToCompanyUserReferenceClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\CompanyRole\CompanyRoleClientInterface
     */
    protected $companyRoleClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Customer\CustomerClientInterface
     */
    protected $customerClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface
     */
    protected $companyUsersMapperInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected $companyRoleResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyRoleTransfer
     */
    protected $restCompanyRoleTransferMock;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var int
     */
    protected $fkCustomer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceBuilderInterfaceMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiClientInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiErrorInterfaceMock = $this->getMockBuilder(RestApiErrorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiToCompanyUserClientInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiToCompanyUserReferenceClientInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserReferenceClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleClientInterfaceMock = $this->getMockBuilder(CompanyRoleClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientInterfaceMock = $this->getMockBuilder(CustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersMapperInterfaceMock = $this->getMockBuilder(CompanyUsersMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseInterfaceMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyRoleTransferMock = $this->getMockBuilder(RestCompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->uuid = 'uuid';

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fkCustomer = 1;

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceInterfaceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersUpdater = new CompanyUsersUpdater(
            $this->restResourceBuilderInterfaceMock,
            $this->companyUsersRestApiClientInterfaceMock,
            $this->restApiErrorInterfaceMock,
            $this->companyUsersRestApiToCompanyUserClientInterfaceMock,
            $this->companyUsersRestApiToCompanyUserReferenceClientInterfaceMock,
            $this->companyRoleClientInterfaceMock,
            $this->customerClientInterfaceMock,
            $this->companyUsersMapperInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyRoleClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUsersRestApiToCompanyUserReferenceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($this->fkCustomer);

        $this->customerClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomerById')
            ->willReturn($this->customerTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyRoleCollection')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUsersRestApiToCompanyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('updateCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUsersMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapCompanyUsersResource')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('setPayload')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResponseInterfaceMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturn($this->restResponseInterfaceMock);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUsersUpdater->update(
                $this->restRequestInterfaceMock,
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyRoleNotFoundError(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyRoleClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUsersUpdater->update(
                $this->restRequestInterfaceMock,
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyUserNotFoundError(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyRoleClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUsersRestApiToCompanyUserReferenceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUsersUpdater->update(
                $this->restRequestInterfaceMock,
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyUserNotFoundErrorSecond(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyRoleClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyRoleByUuid')
            ->willReturn($this->companyRoleResponseTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUsersRestApiToCompanyUserReferenceClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturnOnConsecutiveCalls(true, false);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($this->fkCustomer);

        $this->customerClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomerById')
            ->willReturn($this->customerTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyRoleResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleTransfer')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyRoleCollection')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUsersRestApiToCompanyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('updateCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUsersUpdater->update(
                $this->restRequestInterfaceMock,
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }
}
