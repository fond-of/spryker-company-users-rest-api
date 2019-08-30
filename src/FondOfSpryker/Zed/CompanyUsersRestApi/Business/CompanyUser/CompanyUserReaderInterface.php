<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer;
}
