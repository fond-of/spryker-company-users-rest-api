<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Plugin;

use FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CompanyUsersResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection
    ): ResourceRouteCollectionInterface
    {
        return $resourceRouteCollection
            ->addPost('post')
            ->addDelete('delete')
            ->addGet('get');
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return CompanyUsersRestApiConfig::RESOURCE_COMPANY_USERS;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return CompanyUsersRestApiConfig::CONTROLLER_COMPANY_USERS;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCompanyUsersRequestAttributesTransfer::class;
    }
}
