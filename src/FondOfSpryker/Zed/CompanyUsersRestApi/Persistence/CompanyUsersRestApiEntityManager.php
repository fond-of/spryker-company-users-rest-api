<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiPersistenceFactory getFactory()
 * @method \Generated\Shared\Transfer\SpyCompanyUserEntityTransfer save(\Generated\Shared\Transfer\SpyCompanyUserEntityTransfer $spyCompanyUserEntityTransfer)
 */
class CompanyUsersRestApiEntityManager extends AbstractEntityManager implements CompanyUsersRestApiEntityManagerInterface
{
    protected const COLUMN_COMPANY_USER_IS_ACTIVE = 'IsActive';

    /**
     * @param int $idCompanyUser
     *
     * @return void
     */
    public function deleteCompanyUserById(int $idCompanyUser): void
    {
        $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->filterByIdCompanyUser($idCompanyUser)
            ->update([
                static::COLUMN_COMPANY_USER_IS_ACTIVE => false,
            ]);
    }
}
