<?php

namespace FondOfSpryker\Client\CompanyUsersRestApi;

use Codeception\Test\Unit;
use Spryker\Client\Kernel\Container;

class CompanyUsersRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider
     */
    protected $companyUsersRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiDependencyProvider = new CompanyUsersRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUsersRestApiDependencyProvider->provideServiceLayerDependencies(
                $this->containerMock
            )
        );
    }
}
