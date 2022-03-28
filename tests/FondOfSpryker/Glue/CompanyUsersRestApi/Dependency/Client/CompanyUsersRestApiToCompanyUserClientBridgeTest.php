<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\CompanyUser\CompanyUserClientInterface;

class CompanyUsersRestApiToCompanyUserClientBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientBridge
     */
    protected $companyUsersRestApiToCompanyUserClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\CompanyUser\CompanyUserClientInterface
     */
    protected $companyUserClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    protected $companyUserCollectionTransferMock;

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
        $this->companyUserClientInterfaceMock = $this->getMockBuilder(CompanyUserClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiToCompanyUserClientBridge = new CompanyUsersRestApiToCompanyUserClientBridge(
            $this->companyUserClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetActiveCompanyUsersByCustomerReference(): void
    {
        $this->companyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getActiveCompanyUsersByCustomerReference')
            ->with($this->customerTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->assertInstanceOf(
            CompanyUserCollectionTransfer::class,
            $this->companyUsersRestApiToCompanyUserClientBridge->getActiveCompanyUsersByCustomerReference(
                $this->customerTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testUpdateCompanyUser(): void
    {
        $this->companyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('updateCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUsersRestApiToCompanyUserClientBridge->updateCompanyUser(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDisableCompanyUser(): void
    {
        $this->companyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('disableCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUsersRestApiToCompanyUserClientBridge->disableCompanyUser(
                $this->companyUserTransferMock,
            ),
        );
    }
}
