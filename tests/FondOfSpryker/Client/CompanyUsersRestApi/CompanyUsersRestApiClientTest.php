<?php

namespace FondOfSpryker\Client\CompanyUsersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;

class CompanyUsersRestApiClientTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClient
     */
    protected $companyUsersRestApiClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiFactory
     */
    protected $companyUsersRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface
     */
    protected $companyUsersRestApiStubInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected $restCompanyUsersResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restWriteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restWriteCompanyUserResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUsersRestApiFactoryMock = $this->getMockBuilder(CompanyUsersRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiStubInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersResponseTransferMock = $this->getMockBuilder(RestCompanyUsersResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserRequestTransferMock = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserResponseTransferMock = $this->getMockBuilder(RestDeleteCompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserResponseTransferMock = $this->getMockBuilder(RestWriteCompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiClient = new CompanyUsersRestApiClient();
        $this->companyUsersRestApiClient->setFactory($this->companyUsersRestApiFactoryMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyUsersRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubInterfaceMock);

        $this->companyUsersRestApiStubInterfaceMock->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUsersResponseTransferMock,
            $this->companyUsersRestApiClient->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDisableCompanyUser(): void
    {
        $this->companyUsersRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubInterfaceMock);

        $this->companyUsersRestApiStubInterfaceMock->expects(static::atLeastOnce())
            ->method('disableCompanyUser')
            ->willReturn($this->companyUserResponseTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->companyUsersRestApiClient->disableCompanyUser(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserByRestDeleteCompanyUserRequest(): void
    {
        $this->companyUsersRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubInterfaceMock);

        $this->companyUsersRestApiStubInterfaceMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUserByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn($this->restDeleteCompanyUserResponseTransferMock);

        static::assertEquals(
            $this->restDeleteCompanyUserResponseTransferMock,
            $this->companyUsersRestApiClient->deleteCompanyUserByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testuUpdateCompanyUserByRestDeleteCompanyUserRequest(): void
    {
        $this->companyUsersRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubInterfaceMock);

        $this->companyUsersRestApiStubInterfaceMock->expects(static::atLeastOnce())
            ->method('updateCompanyUserByRestWriteCompanyUserRequest')
            ->with($this->restWriteCompanyUserRequestTransferMock)
            ->willReturn($this->restWriteCompanyUserResponseTransferMock);

        static::assertEquals(
            $this->restWriteCompanyUserResponseTransferMock,
            $this->companyUsersRestApiClient->updateCompanyUserByRestDeleteCompanyUserRequest(
                $this->restWriteCompanyUserRequestTransferMock,
            ),
        );
    }
}
