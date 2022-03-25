<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class RestCompanyUserToCompanyUserMapperTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapper
     */
    protected $restCompanyUserToCompanyUserMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserToCompanyUserMapper = new RestCompanyUserToCompanyUserMapper();
    }

    /**
     * @return void
     */
    public function testMapRestCompanyUserToCompanyUser(): void
    {
        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getIsActive')
            ->willReturn(true);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setIsActive')
            ->willReturn($this->companyUserTransferMock);

        $this->restCompanyUsersRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getIsDefault')
            ->willReturn(true);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setIsDefault')
            ->willReturn($this->companyUserTransferMock);

        $this->assertInstanceOf(
            CompanyUserTransfer::class,
            $this->restCompanyUserToCompanyUserMapper->mapRestCompanyUserToCompanyUser(
                $this->restCompanyUsersRequestAttributesTransferMock,
                $this->companyUserTransferMock,
            ),
        );
    }
}
