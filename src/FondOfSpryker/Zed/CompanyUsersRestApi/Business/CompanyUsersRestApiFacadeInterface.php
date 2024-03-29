<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;

use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;

interface CompanyUsersRestApiFacadeInterface
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
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequest
     *
     * @return \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer
     */
    public function deleteCompanyUserByRestDeleteCompanyUserRequest(
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequest
    ): RestDeleteCompanyUserResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer
     */
    public function updateCompanyUserByRestWriteCompanyUserRequest(
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): RestWriteCompanyUserResponseTransfer;
}
