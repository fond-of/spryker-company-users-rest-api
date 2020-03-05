<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class CompanyUsersRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider
     */
    protected $companyUsersRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
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
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUsersRestApiDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock
            )
        );
    }

    /**
     * @return void
     */
    public function testProvidePersistenceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUsersRestApiDependencyProvider->providePersistenceLayerDependencies(
                $this->containerMock
            )
        );
    }
}
