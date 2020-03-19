<?php

namespace FondOfSpryker\Client\CompanyUsersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface;
use FondOfSpryker\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface;
use Spryker\Client\Kernel\Container;

class CompanyUsersRestApiFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiFactory
     */
    protected $companyUsersRestApiFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface
     */
    protected $companyUsersRestApiToZedRequestClientInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiToZedRequestClientInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiFactory = new CompanyUsersRestApiFactory();
        $this->companyUsersRestApiFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedCompanyUsersRestApiStub(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(CompanyUsersRestApiDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->companyUsersRestApiToZedRequestClientInterfaceMock);

        $this->assertInstanceOf(
            CompanyUsersRestApiStubInterface::class,
            $this->companyUsersRestApiFactory->createZedCompanyUsersRestApiStub()
        );
    }
}
