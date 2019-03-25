<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi;

use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUsersRestApi\CompanyBusinessUnitCompanyUserMapperPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUsersRestApi\CompanyCompanyUserMapperPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUsersRestApi\CompanyUserMapperPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUsersRestApi\CustomerCompanyUserMapperPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompaniesRestApiFacadeBridge;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeBridge;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeBridge;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerB2bFacadeBridge;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToSequenceNumberFacadeBridge;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyUsersRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';
    public const FACADE_CUSTOMER = 'FACADE_CUSTOMER';
    public const FACADE_COMPANIES_REST_API = 'FACADE_COMPANIES_REST_API';
    public const FACADE_COMPANY_BUSINESS_UNITS_REST_API = 'FACADE_COMPANY_BUSINESS_UNITS_REST_API';
    public const FACADE_SEQUENCE_NUMBER = 'FACADE_SEQUENCE_NUMBER';
    public const PLUGINS_COMPANY_USER_MAPPER = 'PLUGINS_COMPANY_USER_MAPPER';
    public const PROPEL_QUERY_COMPANY_USER = 'PROPEL_QUERY_COMPANY_USER';

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
        $container = $this->addSequenceNumberFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = $this->addCompanyUserPropelQuery($container);

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
            return new CompanyUsersRestApiToCustomerB2bFacadeBridge(
                $container->getLocator()->customerB2b()->facade()
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

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSequenceNumberFacade(Container $container): Container
    {
        $container[static::FACADE_SEQUENCE_NUMBER] = function (Container $container) {
            return new CompanyUsersRestApiToSequenceNumberFacadeBridge($container->getLocator()->sequenceNumber()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY_USER] = function () {
            return SpyCompanyUserQuery::create();
        };

        return $container;
    }
}
