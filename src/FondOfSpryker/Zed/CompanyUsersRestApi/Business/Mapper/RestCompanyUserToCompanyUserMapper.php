<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class RestCompanyUserToCompanyUserMapper implements RestCompanyUserToCompanyUserMapperInterface
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
    ): CompanyUserTransfer {
        if ($restCompanyUsersRequestAttributesTransfer->getIsActive() !== null) {
            $companyUserTransfer->setIsActive(
                $restCompanyUsersRequestAttributesTransfer->getIsActive()
            );
        }

        if ($restCompanyUsersRequestAttributesTransfer->getIsDefault() !== null) {
            $companyUserTransfer->setIsDefault(
                $restCompanyUsersRequestAttributesTransfer->getIsDefault()
            );
        }

        return $companyUserTransfer;
    }
}
