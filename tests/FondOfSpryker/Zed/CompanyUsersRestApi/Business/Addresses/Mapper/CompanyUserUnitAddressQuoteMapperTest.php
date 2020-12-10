<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressCollectionTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestAddressTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CompanyUserUnitAddressQuoteMapperTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapper
     */
    protected $companyUserUnitAddressQuoteMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
     */
    protected $companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer
     */
    protected $restCheckoutRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var string
     */
    protected $companyUserReference;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestAddressTransfer
     */
    protected $restAddressTransferMock;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUnitAddressCollectionTransfer
     */
    protected $companyUnitAddressCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    protected $companyUnitAddressTransferMock;

    /**
     * @var array
     */
    protected $companyUnitAddresses;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var int
     */
    protected $idCompanyUnitAddress;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var string
     */
    protected $name1;

    /**
     * @var string
     */
    protected $name2;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutRequestAttributesTransferMock = $this->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReference = 'company-user-reference';

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restAddressTransferMock = $this->getMockBuilder(RestAddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->id = 1;

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUnitAddressCollectionTransferMock = $this->getMockBuilder(CompanyUnitAddressCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUnitAddressTransferMock = $this->getMockBuilder(CompanyUnitAddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUnitAddresses = [
            $this->companyUnitAddressTransferMock,
        ];

        $this->uuid = 1;

        $this->idCompanyUnitAddress = 2;

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->name1 = 'Name1';
        $this->name2 = 'Name2';

        $this->companyUserUnitAddressQuoteMapper = new CompanyUserUnitAddressQuoteMapper(
            $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testMapCompanyUserUnitAddressesToQuote(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects(static::atLeastOnce())
            ->method('getAddressCollection')
            ->willReturn($this->companyUnitAddressCollectionTransferMock);

        $this->companyUnitAddressCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUnitAddresses')
            ->willReturn($this->companyUnitAddresses);

        $this->companyUnitAddressTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyUnitAddressTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->companyUnitAddressTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUnitAddress')
            ->willReturn($this->idCompanyUnitAddress);

        $this->companyUnitAddressTransferMock->expects(static::atLeastOnce())
            ->method('getName1')
            ->willReturn($this->name1);

        $this->companyUnitAddressTransferMock->expects(static::atLeastOnce())
            ->method('getName2')
            ->willReturn($this->name2);

        $this->restCheckoutRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getShippingAddress')
            ->willReturn($this->restAddressTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->companyUserUnitAddressQuoteMapper->mapCompanyUserUnitAddressesToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapCompanyUserUnitAddressesToQuoteCompanyUserResponseNotSuccessful(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->companyUserUnitAddressQuoteMapper->mapCompanyUserUnitAddressesToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapCompanyUserUnitAddressesToQuoteCompanyBusinessUnitNull(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn(null);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->companyUserUnitAddressQuoteMapper->mapCompanyUserUnitAddressesToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapCompanyUserUnitAddressesToQuoteAddressCollectionNull(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects(static::atLeastOnce())
            ->method('getAddressCollection')
            ->willReturn(null);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->companyUserUnitAddressQuoteMapper->mapCompanyUserUnitAddressesToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapCompanyUserUnitAddressesToQuoteContinueCompanyUnitAddress(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects(static::atLeastOnce())
            ->method('getAddressCollection')
            ->willReturn($this->companyUnitAddressCollectionTransferMock);

        $this->companyUnitAddressCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUnitAddresses')
            ->willReturn($this->companyUnitAddresses);

        $this->companyUnitAddressTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn(null);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->companyUserUnitAddressQuoteMapper->mapCompanyUserUnitAddressesToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }
}
