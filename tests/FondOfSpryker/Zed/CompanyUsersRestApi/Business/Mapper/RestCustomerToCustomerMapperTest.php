<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class RestCustomerToCustomerMapperTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapper
     */
    protected $restCustomerToCustomerMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected $customerFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerTransfer
     */
    protected $restCustomerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerFacadeInterfaceMock = $this->getMockBuilder(CustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerToCustomerMapper = new RestCustomerToCustomerMapper(
            $this->customerFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testMapRestCustomerToCustomer(): void
    {
        $this->restCustomerTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('fromArray')
            ->willReturn($this->customerTransferMock);

        $this->assertInstanceOf(
            CustomerTransfer::class,
            $this->restCustomerToCustomerMapper->mapRestCustomerToCustomer(
                $this->restCustomerTransferMock,
                $this->customerTransferMock
            )
        );
    }
}
