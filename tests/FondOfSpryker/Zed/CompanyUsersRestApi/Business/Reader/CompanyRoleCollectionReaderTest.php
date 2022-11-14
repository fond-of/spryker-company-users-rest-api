<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\RestCompanyRoleTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;

class CompanyRoleCollectionReaderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleFacadeMock;
    /**
     * @var \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restWriteCompanyUserRequestTransferMock;
    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUsersRequestAttributesTransferMock;
    /**
     * @var \Generated\Shared\Transfer\RestCompanyRoleTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyRoleTransferMock;
    /**
     * @var \Generated\Shared\Transfer\CompanyRoleResponseTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleResponseTransferMock;
    /**
     * @var \Generated\Shared\Transfer\CompanyRoleTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleTransferMock;
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReader
     */
    protected $companyRoleCollectionReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWriteCompanyUserRequestTransferMock = $this->getMockBuilder(RestWriteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyRoleTransferMock = $this->getMockBuilder(RestCompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionReader = new CompanyRoleCollectionReader(
            $this->companyRoleFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testGetByRestWriteCompanyUserRequest(): void
    {
        $this->restWriteCompanyUserRequestTransferMock->expects(static::atLeastOnce())
    }
}
