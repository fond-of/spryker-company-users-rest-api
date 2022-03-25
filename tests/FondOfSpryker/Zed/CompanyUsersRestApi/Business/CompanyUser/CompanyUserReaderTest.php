<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReader
     */
    protected $companyUserReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface
     */
    protected $companyUsersRestApiRepositoryInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var int
     */
    protected $fkCompanyBusinessUnit;

    /**
     * @var int
     */
    protected $fkCustomer;

    /**
     * @var int
     */
    protected $fkCompany;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \ArrayObject
     */
    protected $companyUsers;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUsersRestApiRepositoryInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fkCompany = 1;

        $this->fkCustomer = 2;

        $this->fkCompanyBusinessUnit = 3;

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsers = new ArrayObject([]);

        $this->companyUserReader = new CompanyUserReader(
            $this->companyUsersRestApiRepositoryInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testDoesCompanyUserAlreadyExist(): void
    {
        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn($this->fkCustomer);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn($this->fkCompany);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompanyBusinessUnit')
            ->willReturn($this->fkCompanyBusinessUnit);

        $this->companyUsersRestApiRepositoryInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUsersByFilter')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($this->companyUsers);

        $this->assertFalse(
            $this->companyUserReader->doesCompanyUserAlreadyExist(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDoesCompanyUserAlreadyExistNoCompanyUser(): void
    {
        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn(null);

        $this->assertFalse(
            $this->companyUserReader->doesCompanyUserAlreadyExist(
                $this->companyUserTransferMock,
            ),
        );
    }
}
