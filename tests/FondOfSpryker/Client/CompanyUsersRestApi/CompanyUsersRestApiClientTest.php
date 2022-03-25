<?php

namespace FondOfSpryker\Client\CompanyUsersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;

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

        $this->companyUsersRestApiClient = new CompanyUsersRestApiClient();
        $this->companyUsersRestApiClient->setFactory($this->companyUsersRestApiFactoryMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyUsersRestApiFactoryMock->expects($this->atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubInterfaceMock);

        $this->companyUsersRestApiStubInterfaceMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
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
        $this->companyUsersRestApiFactoryMock->expects($this->atLeastOnce())
            ->method('createZedCompanyUsersRestApiStub')
            ->willReturn($this->companyUsersRestApiStubInterfaceMock);

        $this->companyUsersRestApiStubInterfaceMock->expects($this->atLeastOnce())
            ->method('disableCompanyUser')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUsersRestApiClient->disableCompanyUser(
                $this->companyUserTransferMock,
            ),
        );
    }
}
