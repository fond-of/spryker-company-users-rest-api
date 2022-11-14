<?php


declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilder;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersReader;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersReaderInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriter;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleter;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilter;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilter;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapper;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapper;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapper;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdater;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdaterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiError;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
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
            $this->getClient(),
            $this->getCompanyUserReferenceClient(),
            $this->createCompanyUsersMapper(),
            $this->createRestApiError(),
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
            $this->getCompanyClient(),
            $this->createRestApiError(),
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdaterInterface
     */
    public function createCompanyUserUpdater(): CompanyUserUpdaterInterface
    {
        return new CompanyUserUpdater(
            $this->createRestWriteCompanyUserRequestMapper(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleterInterface
     */
    public function createCompanyUserDeleter(): CompanyUserDeleterInterface
    {
        return new CompanyUserDeleter(
            $this->createRestDeleteCompanyUserRequestMapper(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface
     */
    protected function createRestDeleteCompanyUserRequestMapper(): RestDeleteCompanyUserRequestMapperInterface
    {
        return new RestDeleteCompanyUserRequestMapper(
            $this->createIdCustomerFilter(),
            $this->createCompanyUserReferenceFilter(),
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface
     */
    protected function createIdCustomerFilter(): IdCustomerFilterInterface
    {
        return new IdCustomerFilter();
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface
     */
    protected function createCompanyUserReferenceFilter(): CompanyUserReferenceFilterInterface
    {
        return new CompanyUserReferenceFilter();
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected function createRestResponseBuilder(): RestResponseBuilderInterface
    {
        return new RestResponseBuilder(
            $this->getResourceBuilder(),
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface
     */
    protected function createCompanyUsersMapper(): CompanyUsersMapperInterface
    {
        return new CompanyUsersMapper(
            $this->getResourceBuilder(),
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface
     */
    protected function createRestWriteCompanyUserRequestMapper(): RestWriteCompanyUserRequestMapperInterface
    {
        return new RestWriteCompanyUserRequestMapper(
            $this->createIdCustomerFilter(),
            $this->createCompanyUserReferenceFilter(),
        );
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface
     */
    protected function getCompanyUserReferenceClient(): CompanyUsersRestApiToCompanyUserReferenceClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER_REFERENCE);
    }

    /**
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientInterface
     */
    protected function getCompanyClient(): CompanyUsersRestApiToCompanyClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::CLIENT_COMPANY);
    }
}
