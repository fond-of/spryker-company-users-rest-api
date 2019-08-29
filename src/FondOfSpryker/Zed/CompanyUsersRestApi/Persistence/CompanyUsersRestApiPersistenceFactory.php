<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence;

use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiDependencyProvider;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface getRepository()
 */
class CompanyUsersRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserPropelQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }
}
