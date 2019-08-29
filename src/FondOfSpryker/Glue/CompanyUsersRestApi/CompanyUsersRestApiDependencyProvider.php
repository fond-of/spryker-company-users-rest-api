<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class CompanyUsersRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_COMPANY_USER = 'CLIENT_COMPANY_USER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addCompanyUserClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCompanyUserClient(Container $container): Container
    {
        $container[static::CLIENT_COMPANY_USER] = static function (Container $container) {
            return new CompanyUsersRestApiToCompanyUserClientBridge($container->getLocator()->companyUser()->client());
        };

        return $container;
    }
}
