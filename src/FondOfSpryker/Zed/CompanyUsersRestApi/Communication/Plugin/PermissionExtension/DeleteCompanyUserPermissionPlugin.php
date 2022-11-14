<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension;

use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Communication\CompanyUsersRestApiCommunicationFactory getFactory()
 */
class DeleteCompanyUserPermissionPlugin extends AbstractPlugin implements PermissionPluginInterface
{
    /**
     * @var string
     */
    public const KEY = 'DeleteCompanyUserPermissionPlugin';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return static::KEY;
    }
}
