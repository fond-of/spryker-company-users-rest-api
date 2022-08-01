<?php

declare(strict_types = 1);

namespace FondOfSpryker\Client\CompanyUsersRestApi\Zed;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;

interface CompanyUsersRestApiStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function create(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function disableCompanyUser(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findActiveCompanyUsersByCustomerReference(
        CustomerTransfer $customerTransfer
    ): CompanyUserCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer
     */
    public function deleteCompanyUserByRestDeleteCompanyUserRequest(
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): RestDeleteCompanyUserResponseTransfer;
}
