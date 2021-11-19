<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeBridge;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToEventBridge;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeBridge;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyUsersRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_COMPANY = 'FACADE_COMPANY';
    public const FACADE_COMPANY_BUSINESS_UNIT = 'FACADE_COMPANY_BUSINESS_UNIT';
    public const FACADE_COMPANY_ROLE = 'FACADE_COMPANY_ROLE';
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';
    public const FACADE_COMPANY_USER_REFERENCE = 'FACADE_COMPANY_USER_REFERENCE';
    public const FACADE_CUSTOMER = 'FACADE_CUSTOMER';
    public const FACADE_EVENT = 'FACADE_EVENT';
    public const FACADE_MAIL = 'FACADE_MAIL';
    public const FACADE_PERMISSION = 'FACADE_PERMISSION';

    public const PROPEL_QUERY_COMPANY_USER = 'PROPEL_QUERY_COMPANY_USER';

    public const SERVICE_UTIL_TEXT = 'SERVICE_UTIL_TEXT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addCompanyBusinessUnitFacade($container);
        $container = $this->addCompanyFacade($container);
        $container = $this->addCompanyRoleFacade($container);
        $container = $this->addCompanyUserFacade($container);
        $container = $this->addCompanyUserReferenceFacade($container);
        $container = $this->addCustomerFacade($container);
        $container = $this->addEventFacade($container);
        $container = $this->addMailFacade($container);
        $container = $this->addUtilTextService($container);

        return $this->addPermissionFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRoleFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_ROLE] = static function (Container $container) {
            return $container->getLocator()->companyRole()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addMailFacade(Container $container): Container
    {
        $container[static::FACADE_MAIL] = static function (Container $container) {
            return $container->getLocator()->mail()->facade();
        };

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
    protected function addUtilTextService(Container $container): Container
    {
        $container[static::SERVICE_UTIL_TEXT] = static function (Container $container) {
            return $container->getLocator()->utilText()->service();
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
        $container[static::FACADE_CUSTOMER] = static function (Container $container) {
            return $container->getLocator()->customer()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY] = static function (Container $container) {
            return $container->getLocator()->company()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyBusinessUnitFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_BUSINESS_UNIT] = static function (Container $container) {
            return $container->getLocator()->companyBusinessUnit()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_USER] = static function (Container $container) {
            return $container->getLocator()->companyUser()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT] = static function (Container $container) {
            return new CompanyUsersRestApiToEventBridge($container->getLocator()->event()->facade());
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
        $container[static::PROPEL_QUERY_COMPANY_USER] = static function () {
            return SpyCompanyUserQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserReferenceFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_USER_REFERENCE] = static function (Container $container) {
            return new CompanyUsersRestApiToCompanyUserReferenceFacadeBridge(
                $container->getLocator()->companyUserReference()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPermissionFacade(Container $container): Container
    {
        $container[static::FACADE_PERMISSION] = static function (Container $container) {
            return new CompanyUsersRestApiToPermissionFacadeBridge(
                $container->getLocator()->permission()->facade()
            );
        };

        return $container;
    }
}
