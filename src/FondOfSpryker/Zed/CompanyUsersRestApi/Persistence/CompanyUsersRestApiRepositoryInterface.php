<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;

interface CompanyUsersRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return array<\Generated\Shared\Transfer\CompanyUserTransfer>
     */
    public function findActiveCompanyUsersByCustomerReference(string $customerReference): array;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findCompanyUsersByFilter(
        CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
    ): CompanyUserCollectionTransfer;
}
