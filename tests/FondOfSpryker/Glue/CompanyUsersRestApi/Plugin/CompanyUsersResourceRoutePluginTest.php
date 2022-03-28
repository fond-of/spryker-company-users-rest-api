<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Plugin;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CompanyUsersResourceRoutePluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Plugin\CompanyUsersResourceRoutePlugin
     */
    protected $companyUsersResourceRoutePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected $resourceRouteCollectionInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionInterfaceMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersResourceRoutePlugin = new CompanyUsersResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addPost')
            ->with('post')
            ->willReturn($this->resourceRouteCollectionInterfaceMock);

        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addPatch')
            ->with('patch')
            ->willReturn($this->resourceRouteCollectionInterfaceMock);

        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addGet')
            ->with('get')
            ->willReturn($this->resourceRouteCollectionInterfaceMock);

        $this->assertInstanceOf(
            ResourceRouteCollectionInterface::class,
            $this->companyUsersResourceRoutePlugin->configure(
                $this->resourceRouteCollectionInterfaceMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        $this->assertSame(
            CompanyUsersRestApiConfig::RESOURCE_COMPANY_USERS,
            $this->companyUsersResourceRoutePlugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        $this->assertSame(
            CompanyUsersRestApiConfig::CONTROLLER_COMPANY_USERS,
            $this->companyUsersResourceRoutePlugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        $this->assertSame(
            RestCompanyUsersRequestAttributesTransfer::class,
            $this->companyUsersResourceRoutePlugin->getResourceAttributesClassName(),
        );
    }
}
