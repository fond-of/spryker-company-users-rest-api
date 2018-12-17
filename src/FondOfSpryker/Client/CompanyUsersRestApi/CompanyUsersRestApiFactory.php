<?php

namespace FondOfSpryker\Client\CompanyUsersRestApi;

use FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface;
use FondOfSpryker\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStub;
use FondOfSpryker\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CompanyUsersRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Client\CompanyUsersRestApi\Zed\CompanyUsersRestApiStubInterface
     */
    public function createZedCompanyUsersRestApiStub(): CompanyUsersRestApiStubInterface
    {
        return new CompanyUsersRestApiStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CompanyUsersRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
