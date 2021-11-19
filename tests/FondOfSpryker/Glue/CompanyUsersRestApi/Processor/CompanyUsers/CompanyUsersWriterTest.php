<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUsersWriterTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriter
     */
    protected $companyUsersWriter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $companyUsersRestApiClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientInterface
     */
    protected $companyUsersRestApiToCompanyClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiErrorInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyTransfer
     */
    protected $restCompanyTransferMock;

    /**
     * @var int
     */
    protected $idCompany;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected $restCompanyUsersResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer
     */
    protected $restCompanyUsersResponseAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceInterfaceMock;

    /**
     * @var string
     */
    protected $companyUserReference;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseInterfaceMock;

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

        $this->companyUsersRestApiToCompanyClientInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiErrorInterfaceMock = $this->getMockBuilder(RestApiErrorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyTransferMock = $this->getMockBuilder(RestCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompany = 1;

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersResponseTransferMock = $this->getMockBuilder(RestCompanyUsersResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersResponseAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersResponseAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceInterfaceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReference = 'company-user-reference';

        $this->restResponseInterfaceMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersWriter = new CompanyUsersWriter(
            $this->restResourceBuilderInterfaceMock,
            $this->companyUsersRestApiClientInterfaceMock,
            $this->companyUsersRestApiToCompanyClientInterfaceMock,
            $this->restApiErrorInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserAccessDeniedError(): void
    {
        $this->restRequestInterfaceMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn(null);

        $this->restApiErrorInterfaceMock->expects(static::atLeastOnce())
            ->method('addAccessDeniedError')
            ->willReturn($this->restResponseInterfaceMock);

        $this->assertEquals(
            $this->restResponseInterfaceMock,
            $this->companyUsersWriter->createCompanyUser(
                $this->restRequestInterfaceMock,
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUser(): void
    {
        $idCustomer = 1;
        $restUserMock = $this->getMockBuilder(RestUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestInterfaceMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($restUserMock);

        $restUserMock->expects(static::atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($idCustomer);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('setCurrentCustomer')
            ->willReturn($this->restCompanyUsersRequestAttributesTransferMock);

        $this->companyUsersRestApiClientInterfaceMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        $this->restCompanyUsersResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->restCompanyUsersResponseTransferMock->expects(static::atLeastOnce())
            ->method('getRestCompanyUsersResponseAttributes')
            ->willReturn($this->restCompanyUsersResponseAttributesTransferMock);

        $this->restResourceBuilderInterfaceMock->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResourceInterfaceMock->expects(static::atLeastOnce())
            ->method('setPayload')
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResourceBuilderInterfaceMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restResponseInterfaceMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturn($this->restResponseInterfaceMock);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUsersWriter->createCompanyUser(
                $this->restRequestInterfaceMock,
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }
}
