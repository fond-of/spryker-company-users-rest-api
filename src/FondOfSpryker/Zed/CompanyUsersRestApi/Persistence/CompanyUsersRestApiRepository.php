<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\CompanyBrandRelationTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiPersistenceFactory getFactory()
 */
class CompanyUsersRestApiRepository extends AbstractRepository implements CompanyUsersRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return array<\Generated\Shared\Transfer\CompanyUserTransfer>
     */
    public function findActiveCompanyUsersByCustomerReference(string $customerReference): array
    {
        /** @var array<\Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUser> $companyUsers */
        $companyUsers = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->useCustomerQuery()
                ->filterByCustomerReference($customerReference)
            ->endUse()
            ->useCompanyQuery()
                ->useFosBrandCompanyQuery(null, Criteria::LEFT_JOIN)
                    ->useFosBrandQuery(null, Criteria::LEFT_JOIN)
                    ->endUse()
                ->endUse()
                ->usePriceListQuery()
                ->endUse()
            ->endUse()
            ->useCompanyBusinessUnitQuery()
            ->endUse()
            ->useSpyCompanyRoleToCompanyUserQuery()
                ->useCompanyRoleQuery()
                ->endUse()
            ->endUse()
            ->find();

        $companyUserTransfers = [];

        foreach ($companyUsers as $companyUser) {
            $companyUserTransfer = (new CompanyUserTransfer())
                ->fromArray($companyUser->toArray(), true);

            $company = $companyUser->getCompany();

            if ($companyUser->getCompany() !== null) {
                $companyTransfer = (new CompanyTransfer())
                    ->fromArray($companyUser->getCompany()->toArray(), true);

                if ($company->getPriceList() !== null) {
                    $companyTransfer->setPriceList(
                        (new PriceListTransfer())
                            ->fromArray($company->getPriceList()->toArray(), true),
                    );
                }

                $brandTransfers = [];

                foreach ($company->getFosBrandCompanies() as $brand) {
                    $brandTransfers[] = (new BrandTransfer())
                        ->fromArray($brand->getFosBrand()->toArray());
                }

                $companyUserTransfer->setCompany(
                    $companyTransfer->setBrandRelation((new CompanyBrandRelationTransfer())->setBrands(new ArrayObject($brandTransfers))),
                );
            }

            if ($companyUser->getCompanyBusinessUnit() !== null) {
                $companyUserTransfer->setCompanyBusinessUnit(
                    (new CompanyBusinessUnitTransfer())
                        ->fromArray($companyUser->getCompanyBusinessUnit()->toArray(), true),
                );
            }

            $companyRoleTransfers = [];

            foreach ($companyUser->getSpyCompanyRoleToCompanyUsers() as $companyRoleToCompanyUsers) {
                $companyRoleTransfers[] = (new CompanyRoleTransfer())
                    ->fromArray($companyRoleToCompanyUsers->getCompanyRole()->toArray(), true);
            }

            $companyUserTransfers[] = $companyUserTransfer
                ->setCompanyRoleCollection((new CompanyRoleCollectionTransfer())->setRoles(new ArrayObject($companyRoleTransfers)));
        }

        return $companyUserTransfers;
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

    /**
     * @param int $idCustomer
     * @param string $foreignCompanyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByIdCustomerAndForeignCompanyUserReference(
        int $idCustomer,
        string $foreignCompanyUserReference
    ): ?CompanyUserTransfer {
        $companyUser = $this->getFactory()
            ->getCompanyUserPropelQuery()
            ->clear()
            ->where(
                sprintf(
                    '%s IN (SELECT %s FROM %s WHERE %s = ?)',
                    SpyCompanyUserTableMap::COL_FK_COMPANY,
                    SpyCompanyUserTableMap::COL_FK_COMPANY,
                    SpyCompanyUserTableMap::TABLE_NAME,
                    SpyCompanyUserTableMap::COL_FK_CUSTOMER,
                ),
                $idCustomer,
            )->filterByCompanyUserReference($foreignCompanyUserReference)
            ->findOne();

        if ($companyUser === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyUserMapper()
            ->mapEntityToTransfer($companyUser);
    }
}
