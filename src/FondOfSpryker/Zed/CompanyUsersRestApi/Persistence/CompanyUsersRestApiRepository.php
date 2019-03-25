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
            ->leftJoinWithCompany()
            ->filterByExternalReference($externalReference);

        $entityTransfer = $this->buildQueryFromCriteria($query)->findOne();

        return $this->getFactory()
            ->createCompanyUserMapper()
            ->mapEntityTransferToCompanyUserTransfer($entityTransfer);
    }
}
