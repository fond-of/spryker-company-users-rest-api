<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

use Codeception\Test\Unit;
use Spryker\Glue\Kernel\Container;

class CompanyUsersRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider
     */
    protected $companyUsersRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
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
    public function testProvideDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUsersRestApiDependencyProvider->provideDependencies(
                $this->containerMock,
            ),
        );
    }
}
