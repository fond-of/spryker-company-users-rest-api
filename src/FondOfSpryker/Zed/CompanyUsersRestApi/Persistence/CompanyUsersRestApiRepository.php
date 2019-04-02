<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiPersistenceFactory getFactory()
 */
class CompanyUsersRestApiRepository extends AbstractRepository implements CompanyUsersRestApiRepositoryInterface
{
    /**
     * @param string $externalReference
     *
     * @throws
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function findCompanyUserByExternalReference(string $externalReference): ?CompanyUserTransfer
    {
        $query = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->joinWithCustomer()
            ->filterByExternalReference($externalReference);

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
     * Specification:
     *  - Retrieve a company user by companyUserReference
     *
     * @api
     *
     * @param string $companyUserReference
     *
     * @throws
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
}
