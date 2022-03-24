<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;

use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReader;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiError;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Spryker\Service\UtilText\UtilTextServiceInterface;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

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
            $this->getRepository()
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
            $this->createCompanyUserReader(),
            $this->getUtilTextService(),
            $this->getConfig(),
            $this->getMailFacade(),
            $this->getCompanyRoleFacade(),
            $this->getPermissionFacade(),
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
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper\CompanyUserUnitAddressQuoteMapperInterface
     */
    public function createCompanyUserUnitAddressQuoteMapper(): CompanyUserUnitAddressQuoteMapperInterface
    {
        return new CompanyUserUnitAddressQuoteMapper(
            $this->getCompanyUserReferenceFacade()
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
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
     */
    protected function getCompanyUserReferenceFacade(): CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE);
    }

    /**
     * @return \Spryker\Service\UtilText\UtilTextServiceInterface
     */
    protected function getUtilTextService(): UtilTextServiceInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::SERVICE_UTIL_TEXT);
    }

    /**
     * @return \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    protected function getMailFacade(): MailFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_ROLE);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyUsersRestApiToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_PERMISSION);
    }
}
