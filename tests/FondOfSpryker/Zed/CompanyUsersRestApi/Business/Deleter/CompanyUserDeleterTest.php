<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Deleter;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserPermissionPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;

class CompanyUserDeleterTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReaderMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $permissionFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleter
     */
    protected $companyUserDeleter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserRequestTransferMock = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserDeleter = new CompanyUserDeleter(
            $this->companyUserReaderMock,
            $this->companyUserFacadeMock,
            $this->permissionFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteByRestDeleteCompanyUserRequest(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestDeleteCompanyUserRequest')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(
                WriteCompanyUserPermissionPlugin::KEY,
                $idCompanyUser,
            )->willReturn(true);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getDeletableByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $restDeleteCompanyUserResponseTransfer = $this->companyUserDeleter->deleteByRestDeleteCompanyUserRequest(
            $this->restDeleteCompanyUserRequestTransferMock,
        );

        static::assertTrue($restDeleteCompanyUserResponseTransfer->getIsSuccess());
    }

    /**
     * @return void
     */
    public function testDeleteByRestDeleteCompanyUserRequestWithoutRequiredPermission(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestDeleteCompanyUserRequest')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(
                WriteCompanyUserPermissionPlugin::KEY,
                $idCompanyUser,
            )->willReturn(false);

        $this->companyUserReaderMock->expects(static::never())
            ->method('getDeletableByRestDeleteCompanyUserRequest');

        $this->companyUserFacadeMock->expects(static::never())
            ->method('deleteCompanyUser');

        $restDeleteCompanyUserResponseTransfer = $this->companyUserDeleter->deleteByRestDeleteCompanyUserRequest(
            $this->restDeleteCompanyUserRequestTransferMock,
        );

        static::assertFalse($restDeleteCompanyUserResponseTransfer->getIsSuccess());
    }

    /**
     * @return void
     */
    public function testDeleteByRestDeleteCompanyUserRequestWithoutDeletableCompanyUser(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestDeleteCompanyUserRequest')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(
                WriteCompanyUserPermissionPlugin::KEY,
                $idCompanyUser,
            )->willReturn(true);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getDeletableByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn(null);

        $this->companyUserFacadeMock->expects(static::never())
            ->method('deleteCompanyUser');

        $restDeleteCompanyUserResponseTransfer = $this->companyUserDeleter->deleteByRestDeleteCompanyUserRequest(
            $this->restDeleteCompanyUserRequestTransferMock,
        );

        static::assertFalse($restDeleteCompanyUserResponseTransfer->getIsSuccess());
    }

    /**
     * @return void
     */
    public function testDeleteByRestDeleteCompanyUserRequestWithDeletionError(): void
    {
        $idCompanyUser = 1;

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getCurrentByRestDeleteCompanyUserRequest')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(
                WriteCompanyUserPermissionPlugin::KEY,
                $idCompanyUser,
            )->willReturn(true);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getDeletableByRestDeleteCompanyUserRequest')
            ->with($this->restDeleteCompanyUserRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->companyUserResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $restDeleteCompanyUserResponseTransfer = $this->companyUserDeleter->deleteByRestDeleteCompanyUserRequest(
            $this->restDeleteCompanyUserRequestTransferMock,
        );

        static::assertFalse($restDeleteCompanyUserResponseTransfer->getIsSuccess());
    }
}
