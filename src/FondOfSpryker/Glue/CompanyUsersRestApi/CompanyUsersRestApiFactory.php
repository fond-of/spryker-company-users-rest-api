<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersReader;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersReaderInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriter;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapper;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiError;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface getClient()
 */
class CompanyUsersRestApiFactory extends AbstractFactory
{
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
     * @return \Spryker\Zed\BusinessOnBehalf\Business\Model\CompanyUser\CompanyUserReaderInterface
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
     * @throws
     *
     * @return \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface
     */
    public function getCompanyUserClient(): CompanyUsersRestApiToCompanyUserClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER);
    }
}
