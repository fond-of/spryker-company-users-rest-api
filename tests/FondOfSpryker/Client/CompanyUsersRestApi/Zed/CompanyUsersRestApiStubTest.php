<?php

namespace FondOfSpryker\Client\CompanyUsersRestApi\Zed;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;

class CompanyUsersRestApiStubTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface
     */
    protected $companyUsersRestApiToZedRequestClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected $restCompanyUsersResponseTransferMock;

    /**
     * @var string
     */
    protected $createUrl;

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
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStub
     */
    protected $companyUsersRestApiStub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUsersRestApiToZedRequestClientInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
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

        $this->companyUsersRestApiStub = new CompanyUsersRestApiStub(
            $this->companyUsersRestApiToZedRequestClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyUsersRestApiToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with('/company-users-rest-api/gateway/create', $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUsersResponseTransferMock,
            $this->companyUsersRestApiStub->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDisableCompanyUser(): void
    {
        $this->companyUsersRestApiToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with('/company-users-rest-api/gateway/disable-company-user', $this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->companyUsersRestApiStub->disableCompanyUser(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserByRestDeleteCompanyUserRequest(): void
    {
        $this->companyUsersRestApiToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with('/company-users-rest-api/gateway/delete-company-user-by-rest-delete-company-user-request', $this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn($this->restDeleteCompanyUserResponseTransferMock);

        static::assertEquals(
            $this->restDeleteCompanyUserResponseTransferMock,
            $this->companyUsersRestApiStub->deleteCompanyUserByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyUserByRestWriteCompanyUserRequest(): void
    {
        $this->companyUsersRestApiToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with('/company-users-rest-api/gateway/update-company-user-by-rest-write-company-user-request',
                $this->restWriteCompanyUserRequestTransferMock,
            )->willReturn($this->restWriteCompanyUserResponseTransferMock);

        static::assertEquals(
            $this->restWriteCompanyUserResponseTransferMock,
            $this->companyUsersRestApiStub->updateCompanyUserByRestWriteCompanyUserRequest(
                $this->restWriteCompanyUserRequestTransferMock,
            ),
        );
    }
}
