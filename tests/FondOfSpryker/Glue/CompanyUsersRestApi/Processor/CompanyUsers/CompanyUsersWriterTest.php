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

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($this->idCompany);

        $this->companyUsersRestApiToCompanyClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyByUuid')
            ->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUsersWriter->createCompanyUser(
                $this->restRequestInterfaceMock,
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserIdCompanyNull(): void
    {

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(null);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->companyUsersWriter->createCompanyUser(
                $this->restRequestInterfaceMock,
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }
}
