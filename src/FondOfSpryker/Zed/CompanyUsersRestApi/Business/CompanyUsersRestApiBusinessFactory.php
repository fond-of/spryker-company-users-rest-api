<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;


use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserDeleter;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserDeleterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReader;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\ReferenceGenerator\CompanyUserReferenceGenerator;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\ReferenceGenerator\CompanyUserReferenceGeneratorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiError;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToSequenceNumberFacadeInterface;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface getRepository()
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiEntityManagerInterface getEntityManager()
 */
class CompanyUsersRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface
     */
    public function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getRepository(),
            $this->getCompanyUserHydrationPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface
     */
    public function createCompanyUserWriter(): CompanyUserWriterInterface
    {
        return new CompanyUserWriter(
            $this->getCustomerFacade(),
            $this->createRestCustomerToCustomerMapper(),
            $this->getCompanyFacade(),
            $this->getCompanyBusinessUnitFacade(),
            $this->getCompanyUserFacade(),
            $this->createRestCompanyUserToCompanyUserMapper(),
            $this->createRestApiError(),
            $this->createCompanyUserReader()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserDeleterInterface
     */
    public function createCompanyUserDeleter(): CompanyUserDeleterInterface
    {
        return new CompanyUserDeleter(
            $this->getEntityManager(),
            $this->getRepository()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface
     */
    public function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface
     */
    public function createRestCompanyUserToCompanyUserMapper(): RestCompanyUserToCompanyUserMapperInterface
    {
        return new RestCompanyUserToCompanyUserMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface
     */
    public function createRestCustomerToCustomerMapper(): RestCustomerToCustomerMapperInterface
    {
        return new RestCustomerToCustomerMapper($this->getCustomerFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\ReferenceGenerator\CompanyUserReferenceGeneratorInterface
     */
    public function createCompanyUserReferenceGenerator(): CompanyUserReferenceGeneratorInterface
    {
        return new CompanyUserReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $this->getConfig()->getCompanyUserReferenceDefaults()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToSequenceNumberFacadeInterface
     */
    protected function getSequenceNumberFacade(): CompanyUsersRestApiToSequenceNumberFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_SEQUENCE_NUMBER);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapperInterface
     */
    public function createCompanyUserUnitAddressQuoteMapper(): CompanyUserUnitAddressQuoteMapperInterface
    {
        return new CompanyUserUnitAddressQuoteMapper(
            $this->getCompanyUsersRestApiFacade()
        );
    }

    /**
     * @return \Spryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER);
    }

    /**
     * @return \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected function getCustomerFacade(): CustomerFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_CUSTOMER);
    }

    /**
     * @return \Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface
     */
    protected function getCompanyUsersRestApiFacade(): CompanyUsersRestApiFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USERS_REST_API);
    }

    /**
     * @return \Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface[]
     */
    protected function getCompanyUserHydrationPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_HYDRATE);
    }
}
