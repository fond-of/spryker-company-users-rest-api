<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriter;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersWriterInterface;
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
}
