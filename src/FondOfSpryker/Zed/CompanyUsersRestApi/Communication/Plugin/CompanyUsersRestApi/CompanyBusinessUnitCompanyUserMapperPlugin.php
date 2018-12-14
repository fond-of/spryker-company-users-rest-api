<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUsersRestApi;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Plugin\CompanyUserMapperPluginInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface getFacade()
 */
class CompanyBusinessUnitCompanyUserMapperPlugin extends AbstractPlugin implements CompanyUserMapperPluginInterface
{
    /**
     * Specification:
     * - Maps rest company user request data to company user transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function map(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        return $this->getFacade()->mapCompanyBusinessUnitToCompanyUser(
            $restCompanyUsersRequestAttributesTransfer,
            $companyUserTransfer
        );
    }
}
