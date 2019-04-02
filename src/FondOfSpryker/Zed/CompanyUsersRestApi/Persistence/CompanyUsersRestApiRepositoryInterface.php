<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUsersRestApiRepositoryInterface
{
    /**
     * Specification:
     *  - Retrieve a company user by externalReference
     *
     * @api
     *
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByExternalReference(string $externalReference): ?CompanyUserTransfer;

    /**
     * Specification:
     *  - Retrieve a company user by companyUserReference
     *
     * @api
     *
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByCompanyUserReference(string $companyUserReference): ?CompanyUserTransfer;
}
