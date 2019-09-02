<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiPersistenceFactory getFactory()
 */
class CompanyUsersRestApiRepository extends AbstractRepository implements CompanyUsersRestApiRepositoryInterface
{
    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByCompanyUserReference(string $companyUserReference): ?CompanyUserTransfer
    {
        $query = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->filterByCompanyUserReference($companyUserReference);

        $companyUserEntityTransfer = $this->buildQueryFromCriteria($query)->findOne();

        if ($companyUserEntityTransfer === null) {
            return null;
        }

        $companyUserTransfer = (new CompanyUserTransfer())->fromArray(
            $companyUserEntityTransfer->toArray(),
            true
        );

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUsersByFilter(
        CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
    ): CompanyUserCollectionTransfer {
        $queryCompanyUser = $this->getFactory()
            ->getCompanyUserPropelQuery();

        $this->applyFilters($queryCompanyUser, $companyUserCriteriaFilterTransfer);

        $companyUserCollection = $this->buildQueryFromCriteria($queryCompanyUser)->find();

        return $this->getFactory()
            ->createCompanyUserMapper()
            ->mapCompanyUserCollection($companyUserCollection);
    }

    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery $queryCompanyUser
     * @param \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer
     *
     * @return void
     */
    protected function applyFilters(SpyCompanyUserQuery $queryCompanyUser, CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer): void
    {
        if ($criteriaFilterTransfer->getIdCompany() !== null) {
            $queryCompanyUser->filterByFkCompany($criteriaFilterTransfer->getIdCompany());
        }

        if ($criteriaFilterTransfer->getIdCustomer() !== null) {
            $queryCompanyUser->filterByFkCustomer($criteriaFilterTransfer->getIdCustomer());
        }

        if ($criteriaFilterTransfer->getIdCompanyBusinessUnit() !== null) {
            $queryCompanyUser->filterByFkCompanyBusinessUnit($criteriaFilterTransfer->getIdCompanyBusinessUnit());
        }
    }
}
