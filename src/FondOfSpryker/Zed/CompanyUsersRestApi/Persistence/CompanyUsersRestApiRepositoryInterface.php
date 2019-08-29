<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUsersRestApiRepositoryInterface
{
    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByCompanyUserReference(string $companyUserReference): ?CompanyUserTransfer;
}
