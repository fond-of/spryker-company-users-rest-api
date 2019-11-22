<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientBridge;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class CompanyUsersRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_COMPANY_ROLE = 'CLIENT_COMPANY_ROLE';
    public const CLIENT_COMPANY_USER = 'CLIENT_COMPANY_USER';
    public const CLIENT_COMPANY_USER_REFERENCE = 'CLIENT_COMPANY_USER_REFERENCE';
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addCompanyRole($container);
        $container = $this->addCompanyUserClient($container);
        $container = $this->addCompanyUserReferenceClient($container);
        $container = $this->addCustomerClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCustomerClient(Container $container): Container
    {
        $container[static::CLIENT_CUSTOMER] = static function (Container $container) {
            return $container->getLocator()->customer()->client();
        };

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

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCompanyRole(Container $container): Container
    {
        $container[static::CLIENT_COMPANY_ROLE] = static function (Container $container) {
            return $container->getLocator()->companyRole()->client();
        };

        return $container;
    }

    protected function addCompanyUserReferenceClient(Container $container): Container
    {
        $container[static::CLIENT_COMPANY_USER_REFERENCE] = static function (Container $container) {
            return new CompanyUsersRestApiToCompanyUserReferenceClientBridge(
                $container->getLocator()->companyUserReference()->client()
            );
        };

        return $container;
    }
}
