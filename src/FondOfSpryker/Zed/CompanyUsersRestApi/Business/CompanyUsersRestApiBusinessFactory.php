<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;

use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleter;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGenerator;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGenerator;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGenerator;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapper;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReader;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReader;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CustomerReader;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CustomerReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Updater\CompanyUserUpdater;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Updater\CompanyUserUpdaterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiError;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriter;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriterInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface getRepository()
 */
class CompanyUsersRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface
     */
    public function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getCompanyUserReferenceFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Deleter\CompanyUserDeleterInterface
     */
    public function createCompanyUserDeleter(): CompanyUserDeleterInterface
    {
        return new CompanyUserDeleter(
            $this->createCompanyUserReader(),
            $this->getCompanyUserFacade(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriterInterface
     */
    public function createCompanyUserWriter(): CompanyUserWriterInterface
    {
        return new CompanyUserWriter(
            $this->createCustomerReader(),
            $this->createCustomerWriter(),
            $this->getCompanyFacade(),
            $this->getCompanyBusinessUnitFacade(),
            $this->getCompanyUserFacade(),
            $this->createCompanyUserMapper(),
            $this->createRestApiError(),
            $this->createCompanyUserReader(),
            $this->getConfig(),
            $this->getPermissionFacade(),
            $this->createCompanyUserPluginExecutor(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface
     */
    protected function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface
     */
    protected function createCustomerMapper(): CustomerMapperInterface
    {
        return new CustomerMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CustomerReaderInterface
     */
    protected function createCustomerReader(): CustomerReaderInterface
    {
        return new CustomerReader(
            $this->createCustomerMapper(),
            $this->getCustomerFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriterInterface
     */
    protected function createCustomerWriter(): CustomerWriterInterface
    {
        return new CustomerWriter(
            $this->createCustomerMapper(),
            $this->createRandomPasswordGenerator(),
            $this->createRestorePasswordKeyGenerator(),
            $this->createRestorePasswordLinkGenerator(),
            $this->getCustomerFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface
     */
    protected function createRandomPasswordGenerator(): RandomPasswordGeneratorInterface
    {
        return new RandomPasswordGenerator($this->getUtilTextService());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface
     */
    protected function getUtilTextService(): CompanyUsersRestApiToUtilTextServiceInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::SERVICE_UTIL_TEXT);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface
     */
    protected function createRestorePasswordKeyGenerator(): RestorePasswordKeyGeneratorInterface
    {
        return new RestorePasswordKeyGenerator($this->getUtilTextService());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface
     */
    protected function createRestorePasswordLinkGenerator(): RestorePasswordLinkGeneratorInterface
    {
        return new RestorePasswordLinkGenerator($this->getConfig());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyUsersRestApiToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyUsersRestApiToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected function getCustomerFacade(): CompanyUsersRestApiToCustomerFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_CUSTOMER);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyUsersRestApiToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_PERMISSION);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
     */
    protected function getCompanyUserReferenceFacade(): CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface
     */
    protected function createCompanyUserPluginExecutor(): CompanyUserPluginExecutorInterface
    {
        return new CompanyUserPluginExecutor(
            $this->getCompanyUserPreCreatePlugins(),
            $this->getCompanyUserPostCreatePlugins(),
        );
    }

    /**
     * @return array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface>
     */
    protected function getCompanyUserPostCreatePlugins(): array
    {
        return $this->getProvidedDependency(
            CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_POST_CREATE,
        );
    }

    /**
     * @return array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreCreatePluginInterface>
     */
    protected function getCompanyUserPreCreatePlugins(): array
    {
        return $this->getProvidedDependency(
            CompanyUsersRestApiDependencyProvider::PLUGINS_COMPANY_USER_PRE_CREATE,
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Updater\CompanyUserUpdaterInterface
     */
    public function createCompanyUserUpdater(): CompanyUserUpdaterInterface
    {
        return new CompanyUserUpdater(
            $this->createCompanyUserReader(),
            $this->createCompanyRoleCollectionReader(),
            $this->getCompanyUserFacade(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface
     */
    protected function createCompanyRoleCollectionReader(): CompanyRoleCollectionReaderInterface
    {
        return new CompanyRoleCollectionReader($this->getCompanyRoleFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyUsersRestApiToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::FACADE_COMPANY_ROLE);
    }
}
