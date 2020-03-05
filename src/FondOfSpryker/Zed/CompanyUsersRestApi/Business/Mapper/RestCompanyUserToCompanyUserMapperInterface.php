<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

interface RestCompanyUserToCompanyUserMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapRestCompanyUserToCompanyUser(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer;
}
