<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi;

use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUsersRestApi\CompanyBusinessUnitCompanyUserMapperPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUsersRestApi\CompanyCompanyUserMapperPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUsersRestApi\CompanyUserMapperPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUsersRestApi\CustomerCompanyUserMapperPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompaniesRestApiFacadeBridge;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeBridge;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeBridge;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyUsersRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';
    public const FACADE_CUSTOMER = 'FACADE_CUSTOMER';
    public const FACADE_COMPANIES_REST_API = 'FACADE_COMPANIES_REST_API';
    public const FACADE_COMPANY_BUSINESS_UNITS_REST_API = 'FACADE_COMPANY_BUSINESS_UNITS_REST_API';
    public const PLUGINS_COMPANY_USER_MAPPER = 'PLUGINS_COMPANY_USER_MAPPER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addCompanyUserFacade($container);
        $container = $this->addCustomerFacade($container);
        $container = $this->addCompaniesRestApiFacade($container);
        $container = $this->addCompanyBusinessUnitsRestApiFacade($container);
        $container = $this->addCompanyUserMapperPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_USER] = function (Container $container) {
            return new CompanyUsersRestApiToCompanyUserFacadeBridge(
                $container->getLocator()->companyUser()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerFacade(Container $container): Container
    {
        $container[static::FACADE_CUSTOMER] = function (Container $container) {
            return new CompanyUsersRestApiToCustomerFacadeBridge(
                $container->getLocator()->customer()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompaniesRestApiFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANIES_REST_API] = function (Container $container) {
            return new CompanyUsersRestApiToCompaniesRestApiFacadeBridge(
                $container->getLocator()->companiesRestApi()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyBusinessUnitsRestApiFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_BUSINESS_UNITS_REST_API] = function (Container $container) {
            return new CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeBridge(
                $container->getLocator()->companyBusinessUnitsRestApi()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserMapperPlugins(Container $container): Container
    {
        $container[static::PLUGINS_COMPANY_USER_MAPPER] = function () {
            return $this->getCompanyUserMapperPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Plugin\CompanyUserMapperPluginInterface[]
     */
    protected function getCompanyUserMapperPlugins(): array
    {
        return [
            new CompanyUserMapperPlugin(),
            new CompanyCompanyUserMapperPlugin(),
            new CompanyBusinessUnitCompanyUserMapperPlugin(),
            new CustomerCompanyUserMapperPlugin(),
        ];
    }
}
