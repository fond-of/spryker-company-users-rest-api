<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CheckoutRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacade;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CompanyUserUnitAddressQuoteMapperPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CheckoutRestApi\CompanyUserUnitAddressQuoteMapperPlugin
     */
    protected $companyUserUnitAddressQuoteMapperPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer
     */
    protected $restCheckoutRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacade
     */
    protected $companyUsersRestApiFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUsersRestApiFacadeMock = $this->getMockBuilder(CompanyUsersRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutRequestAttributesTransferMock = $this->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserUnitAddressQuoteMapperPlugin = new CompanyUserUnitAddressQuoteMapperPlugin();
        $this->companyUserUnitAddressQuoteMapperPlugin->setFacade($this->companyUsersRestApiFacadeMock);
    }

    /**
     * @return void
     */
    public function testMap(): void
    {
        $this->companyUsersRestApiFacadeMock->expects($this->atLeastOnce())
            ->method('mapCompanyUserUnitAddressesToQuote')
            ->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->companyUserUnitAddressQuoteMapperPlugin->map(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteTransferMock
            )
        );
    }
}
