<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CompanyUsersRestApiToCompanyUserClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function getActiveCompanyUsersByCustomerReference(
        CustomerTransfer $customerTransfer
    ): CompanyUserCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function updateCompanyUser(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer;
}
