<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\CompanyUserExtension;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPreSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface getFacade()
 */
class AddReferenceCompanyUserPreSavePlugin extends AbstractPlugin implements CompanyUserPreSavePluginInterface
{
    /**
     * Specification:
     * - Executes plugins before a company user is saved
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function preSave(CompanyUserResponseTransfer $companyUserResponseTransfer): CompanyUserResponseTransfer
    {
        $companyUser = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUser !== null && $companyUser->getCompanyUserReference() === null) {
            $companyUserReference = $this->getFacade()->generateCompanyUserReference();
            $companyUser->setCompanyUserReference($companyUserReference);
        }

        return $companyUserResponseTransfer;
    }
}
