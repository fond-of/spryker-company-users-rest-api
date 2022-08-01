<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleterInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;

class CompanyUsersRestApiFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiBusinessFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface
     */
    protected $companyUserWriterMock;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer
     */
    protected $restCheckoutRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserDeleterMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restDeleteCompanyUserResponseTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacade
     */
    protected $companyUsersRestApiFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(CompanyUsersRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserWriterMock = $this->getMockBuilder(CompanyUserWriterInterface::class)
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

        $this->restCheckoutRequestAttributesTransferMock = $this->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserDeleterMock = $this->getMockBuilder(CompanyUserDeleterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserRequestTransferMock = $this->getMockBuilder(RestDeleteCompanyUserRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDeleteCompanyUserResponseTransferMock = $this->getMockBuilder(RestDeleteCompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiFacade = new CompanyUsersRestApiFacade();
        $this->companyUsersRestApiFacade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserWriter')
            ->willReturn($this->companyUserWriterMock);

        $this->companyUserWriterMock->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        static::assertEquals(
            $this->restCompanyUsersResponseTransferMock,
            $this->companyUsersRestApiFacade->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDisableCompanyUser(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserWriter')
            ->willReturn($this->companyUserWriterMock);

        $this->companyUserWriterMock->expects(static::atLeastOnce())
            ->method('disableCompanyUser')
            ->willReturn($this->companyUserResponseTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->companyUsersRestApiFacade->disableCompanyUser(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserByRestDeleteCompanyUserRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserDeleter')
            ->willReturn($this->companyUserDeleterMock);

        $this->companyUserDeleterMock->expects(static::atLeastOnce())
            ->method('deleteByRestDeleteCompanyUserRequest')
            ->willReturn($this->restDeleteCompanyUserResponseTransferMock);

        static::assertEquals(
            $this->restDeleteCompanyUserResponseTransferMock,
            $this->companyUsersRestApiFacade->deleteCompanyUserByRestDeleteCompanyUserRequest(
                $this->restDeleteCompanyUserRequestTransferMock,
            ),
        );
    }
}
