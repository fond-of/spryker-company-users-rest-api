<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersDeleter;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersDeleterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersReader;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersReaderInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersUpdater;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersUpdaterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriter;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapper;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiError;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Spryker\Client\CompanyRole\CompanyRoleClientInterface;
use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface getClient()
 */
class CompanyUsersRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersReaderInterface
     */
    public function createCompanyUsersReader(): CompanyUsersReaderInterface
    {
        return new CompanyUsersReader(
            $this->getResourceBuilder(),
            $this->getCompanyUserClient(),
            $this->createCompanyUsersMapper(),
            $this->createRestApiError()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersDeleterInterface
     */
    public function createCompanyUsersDeleter(): CompanyUsersDeleterInterface
    {
        return new CompanyUsersDeleter(
            $this->getResourceBuilder(),
            $this->getClient()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriterInterface
     */
    public function createCompanyUsersWriter(): CompanyUsersWriterInterface
    {
        return new CompanyUsersWriter(
            $this->getResourceBuilder(),
            $this->getClient(),
            $this->createRestApiError()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersUpdaterInterface
     */
    public function createCompanyUsersUpdater(): CompanyUsersUpdaterInterface
    {
        return new CompanyUsersUpdater(
            $this->getResourceBuilder(),
            $this->getClient(),
            $this->createRestApiError(),
            $this->getCompanyUserClient(),
            $this->getCompanyRoleClient(),
            $this->getCustomerClient(),
            $this->createCompanyUsersMapper()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    public function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface
     */
    public function createCompanyUsersMapper(): CompanyUsersMapperInterface
    {
        return new CompanyUsersMapper(
            $this->getResourceBuilder()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface
     */
    public function getCompanyUserClient(): CompanyUsersRestApiToCompanyUserClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER);
    }

    /**
     * @return \Spryker\Client\CompanyRole\CompanyRoleClientInterface
     */
    public function getCompanyRoleClient(): CompanyRoleClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_ROLE);
    }

    /**
     * @return \Spryker\Client\Customer\CustomerClientInterface
     */
    public function getCustomerClient(): CustomerClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::CLIENT_CUSTOMER);
    }
}
