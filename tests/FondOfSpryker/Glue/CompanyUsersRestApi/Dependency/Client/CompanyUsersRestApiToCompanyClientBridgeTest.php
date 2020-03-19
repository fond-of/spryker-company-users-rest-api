<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Client\Company\CompanyClientInterface;

class CompanyUsersRestApiToCompanyClientBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientBridge
     */
    protected $companyUsersRestApiToCompanyClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Company\CompanyClientInterface
     */
    protected $companyClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyClientInterfaceMock = $this->getMockBuilder(CompanyClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiToCompanyClientBridge = new CompanyUsersRestApiToCompanyClientBridge(
            $this->companyClientInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyByUuid(): void
    {
        $this->companyClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyByUuid')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyResponseTransferMock);

        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $this->companyUsersRestApiToCompanyClientBridge->findCompanyByUuid(
                $this->companyTransferMock
            )
        );
    }
}
