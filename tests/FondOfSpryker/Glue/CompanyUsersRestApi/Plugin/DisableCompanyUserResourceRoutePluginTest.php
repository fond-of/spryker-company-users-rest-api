<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Plugin;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\RestDisableCompanyUserRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class DisableCompanyUserResourceRoutePluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Plugin\DisableCompanyUserResourceRoutePlugin
     */
    protected $disableCompanyUsersResourceRoutePlugin;

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

        $this->disableCompanyUsersResourceRoutePlugin = new DisableCompanyUserResourceRoutePlugin();
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

        $this->assertInstanceOf(
            ResourceRouteCollectionInterface::class,
            $this->disableCompanyUsersResourceRoutePlugin->configure(
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
            CompanyUsersRestApiConfig::RESOURCE_DISABLE_COMPANY_USER,
            $this->disableCompanyUsersResourceRoutePlugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        $this->assertSame(
            CompanyUsersRestApiConfig::CONTROLLER_DISABLE_COMPANY_USER,
            $this->disableCompanyUsersResourceRoutePlugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        $this->assertSame(
            RestDisableCompanyUserRequestAttributesTransfer::class,
            $this->disableCompanyUsersResourceRoutePlugin->getResourceAttributesClassName(),
        );
    }
}
