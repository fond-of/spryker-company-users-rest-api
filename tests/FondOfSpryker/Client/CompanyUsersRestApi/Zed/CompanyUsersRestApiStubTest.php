<?php

namespace FondOfSpryker\Client\CompanyUsersRestApi\Zed;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;

class CompanyUsersRestApiStubTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStub
     */
    protected $companyUsersRestApiStub;

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

        $this->createUrl = '/company-users-rest-api/gateway/create';

        $this->companyUsersRestApiStub = new CompanyUsersRestApiStub(
            $this->companyUsersRestApiToZedRequestClientInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyUsersRestApiToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with($this->createUrl, $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUsersRestApiStub->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testDisableCompanyUser(): void
    {
        $this->companyUsersRestApiToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with("/company-users-rest-api/gateway/disable-company-user", $this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUsersRestApiStub->disableCompanyUser(
                $this->companyUserTransferMock
            )
        );
    }
}
