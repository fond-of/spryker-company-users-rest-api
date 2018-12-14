<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyCompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompaniesRestApiFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class CompanyCompanyUserMapper implements CompanyCompanyUserMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompaniesRestApiFacadeInterface
     */
    protected $companiesRestApiFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompaniesRestApiFacadeInterface $companiesRestApiFacade
     */
    public function __construct(CompanyUsersRestApiToCompaniesRestApiFacadeInterface $companiesRestApiFacade)
    {
        $this->companiesRestApiFacade = $companiesRestApiFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapCompanyToCompanyUser(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        $restCompanyTransfer = $restCompanyUsersRequestAttributesTransfer->getCompany();

        if ($restCompanyTransfer === null || $restCompanyTransfer->getExternalReference() === null) {
            return $companyUserTransfer;
        }

        $companyTransfer = $this->companiesRestApiFacade
            ->findByExternalReference($restCompanyTransfer->getExternalReference());

        if ($companyTransfer !== null) {
            return $companyUserTransfer;
        }

        $companyUserTransfer->setCompany($companyTransfer)
            ->setFkCompany($companyTransfer->getIdCompany());

        return $companyUserTransfer;
    }
}
