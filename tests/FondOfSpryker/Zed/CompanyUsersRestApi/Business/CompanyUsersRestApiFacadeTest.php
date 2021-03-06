<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserDeleterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;

class CompanyUsersRestApiFacadeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacade
     */
    protected $companyUsersRestApiFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiBusinessFactory
     */
    protected $companyUsersRestApiBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface
     */
    protected $companyUserWriterInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected $restCompanyUsersResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserDeleterInterface
     */
    protected $companyUserDeleterInterfaceMock;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapperInterface
     */
    protected $companyUserUnitAddressQuoteMapperInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUsersRestApiBusinessFactoryMock = $this->getMockBuilder(CompanyUsersRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserWriterInterfaceMock = $this->getMockBuilder(CompanyUserWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersResponseTransferMock = $this->getMockBuilder(RestCompanyUsersResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserDeleterInterfaceMock = $this->getMockBuilder(CompanyUserDeleterInterface::class)
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

        $this->companyUserUnitAddressQuoteMapperInterfaceMock = $this->getMockBuilder(CompanyUserUnitAddressQuoteMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiFacade = new CompanyUsersRestApiFacade();
        $this->companyUsersRestApiFacade->setFactory($this->companyUsersRestApiBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyUsersRestApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyUserWriter')
            ->willReturn($this->companyUserWriterInterfaceMock);

        $this->companyUserWriterInterfaceMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->restCompanyUsersResponseTransferMock);

        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUsersRestApiFacade->create(
                $this->restCompanyUsersRequestAttributesTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $this->companyUsersRestApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyUserDeleter')
            ->willReturn($this->companyUserDeleterInterfaceMock);

        $this->companyUserDeleterInterfaceMock->expects($this->atLeastOnce())
            ->method('delete')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUsersRestApiFacade->delete(
                $this->companyUserTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapCompanyUserUnitAddressToQuote(): void
    {
        $this->companyUsersRestApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyUserUnitAddressQuoteMapper')
            ->willReturn($this->companyUserUnitAddressQuoteMapperInterfaceMock);

        $this->companyUserUnitAddressQuoteMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapCompanyUserUnitAddressesToQuote')
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->companyUsersRestApiFacade->mapCompanyUserUnitAddressesToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }
}
