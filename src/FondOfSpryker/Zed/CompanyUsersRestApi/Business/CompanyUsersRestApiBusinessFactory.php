<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;

use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyBusinessUnitCompanyUser\CompanyBusinessUnitCompanyUserMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyBusinessUnitCompanyUser\CompanyBusinessUnitCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyCompanyUser\CompanyCompanyUserMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyCompanyUser\CompanyCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CustomerCompanyUser\CustomerCompanyUserMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CustomerCompanyUser\CustomerCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompaniesRestApiFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerB2bFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CompanyUsersRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface
     */
    public function createCompanyUserWriter(): CompanyUserWriterInterface
    {
        return new CompanyUserWriter(
            $this->getCompanyUserFacade(),
            $this->getCompanyUserMapperPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserMapperInterface
     */
    public function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyCompanyUser\CompanyCompanyUserMapperInterface
     */
    public function createCompanyCompanyUserMapper(): CompanyCompanyUserMapperInterface
    {
        return new CompanyCompanyUserMapper($this->getCompaniesRestApiFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyBusinessUnitCompanyUser\CompanyBusinessUnitCompanyUserMapperInterface
     */
    public function createCompanyBusinessUnitCompanyUserMapper(): CompanyBusinessUnitCompanyUserMapperInterface
    {
        return new CompanyBusinessUnitCompanyUserMapper($this->getCompanyBusinessUnitsRestApiFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CustomerCompanyUser\CustomerCompanyUserMapperInterface
     */
    public function createCustomerCompanyUserMapper(): CustomerCompanyUserMapperInterface
    {
        return new CustomerCompanyUserMapper($this->getCustomerFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyUsersRestApiToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerB2bFacadeInterface
     */
    protected function getCustomerFacade(): CompanyUsersRestApiToCustomerB2bFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_CUSTOMER);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompaniesRestApiFacadeInterface
     */
    protected function getCompaniesRestApiFacade(): CompanyUsersRestApiToCompaniesRestApiFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANIES_REST_API);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeInterface
     */
    protected function getCompanyBusinessUnitsRestApiFacade(): CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNITS_REST_API);
    }

    /**
     * @return \FondOfSpryker\Zed\CompaniesRestApi\Dependency\Plugin\CompanyMapperPluginInterface[]
     */
    protected function getCompanyUserMapperPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_MAPPER);
    }
}
