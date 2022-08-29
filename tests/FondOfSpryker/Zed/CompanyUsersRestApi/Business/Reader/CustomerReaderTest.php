<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader;

use Codeception\Test\Unit;
use Exception;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CustomerReaderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerMapperMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestCustomerTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCustomerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $customerTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CustomerReader
     */
    protected $customerReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerMapperMock = $this->getMockBuilder(CustomerMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReader = new CustomerReader(
            $this->customerMapperMock,
            $this->customerFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCustomer(): void
    {
        $this->customerMapperMock->expects(static::atLeastOnce())
        ->method('fromRestCustomer')
        ->with($this->restCustomerTransferMock)
        ->willReturn($this->customerTransferMock);

        $this->customerFacadeMock->expects(static::atLeastOnce())
        ->method('getCustomer')
        ->with($this->customerTransferMock)
        ->willReturn($this->customerTransferMock);

        static::assertEquals(
            $this->customerTransferMock,
            $this->customerReader->getByRestCustomer($this->restCustomerTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetByRestCustomerWithInvalidData(): void
    {
        $this->customerMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCustomer')
            ->with($this->restCustomerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->customerFacadeMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willThrowException(new Exception('foo'));

        try {
            $this->customerReader->getByRestCustomer($this->restCustomerTransferMock);
            static::fail();
        } catch (Exception $exception) {
        }
    }
}
