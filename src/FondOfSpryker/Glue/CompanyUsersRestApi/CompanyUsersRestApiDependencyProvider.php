<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientBridge;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class CompanyUsersRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_COMPANY_USER_REFERENCE = 'CLIENT_COMPANY_USER_REFERENCE';

    /**
     * @var string
     */
    public const CLIENT_COMPANY = 'CLIENT_COMPANY';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addCompanyClient($container);

        return $this->addCompanyUserReferenceClient($container);
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCompanyUserReferenceClient(Container $container): Container
    {
        $container[static::CLIENT_COMPANY_USER_REFERENCE] = static function (Container $container) {
            return new CompanyUsersRestApiToCompanyUserReferenceClientBridge(
                $container->getLocator()->companyUserReference()->client(),
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCompanyClient(Container $container): Container
    {
        $container[static::CLIENT_COMPANY] = static function (Container $container) {
            return new CompanyUsersRestApiToCompanyClientBridge(
                $container->getLocator()->company()->client(),
            );
        };

        return $container;
    }
}
