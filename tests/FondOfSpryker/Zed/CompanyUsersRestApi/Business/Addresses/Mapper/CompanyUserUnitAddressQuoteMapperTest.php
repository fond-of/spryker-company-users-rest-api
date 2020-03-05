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
    protected $nameCompany;

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

        $this->nameCompany = 'name-company';

        $this->companyUserUnitAddressQuoteMapper = new CompanyUserUnitAddressQuoteMapper(
            $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testMapCompanyUserUnitAddressesToQuote(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getAddressCollection')
            ->willReturn($this->companyUnitAddressCollectionTransferMock);

        $this->companyUnitAddressCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUnitAddresses')
            ->willReturn($this->companyUnitAddresses);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyUnitAddress')
            ->willReturn($this->idCompanyUnitAddress);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->nameCompany);

        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getShippingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
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
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->assertInstanceOf(
            QuoteTransfer::class,
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
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn(null);

        $this->assertInstanceOf(
            QuoteTransfer::class,
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
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getAddressCollection')
            ->willReturn(null);

        $this->assertInstanceOf(
            QuoteTransfer::class,
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
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getAddressCollection')
            ->willReturn($this->companyUnitAddressCollectionTransferMock);

        $this->companyUnitAddressCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUnitAddresses')
            ->willReturn($this->companyUnitAddresses);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn(null);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->companyUserUnitAddressQuoteMapper->mapCompanyUserUnitAddressesToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapCompanyUserUnitAddressesToQuoteCompanyBusinessUnitCompanyName(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getAddressCollection')
            ->willReturn($this->companyUnitAddressCollectionTransferMock);

        $this->companyUnitAddressCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUnitAddresses')
            ->willReturn($this->companyUnitAddresses);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyUnitAddress')
            ->willReturn($this->idCompanyUnitAddress);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->nameCompany);

        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getShippingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->companyUserUnitAddressQuoteMapper->mapCompanyUserUnitAddressesToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapCompanyUserUnitAddressesToQuoteNoCompany(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($this->companyUserReference);

        $this->companyUsersRestApiToCompanyUserReferenceFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getBillingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restAddressTransferMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->id);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getAddressCollection')
            ->willReturn($this->companyUnitAddressCollectionTransferMock);

        $this->companyUnitAddressCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUnitAddresses')
            ->willReturn($this->companyUnitAddresses);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('getUuid')
            ->willReturn($this->uuid);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->companyUnitAddressTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyUnitAddress')
            ->willReturn($this->idCompanyUnitAddress);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getShippingAddress')
            ->willReturn($this->restAddressTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->companyUserUnitAddressQuoteMapper->mapCompanyUserUnitAddressesToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }
}
