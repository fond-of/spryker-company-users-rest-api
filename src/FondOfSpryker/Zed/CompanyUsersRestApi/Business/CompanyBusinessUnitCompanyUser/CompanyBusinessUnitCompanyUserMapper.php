<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyBusinessUnitCompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class CompanyBusinessUnitCompanyUserMapper implements CompanyBusinessUnitCompanyUserMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeInterface
     */
    protected $companyBusinessUnitsRestApiFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeInterface $companyBusinessUnitsRestApiFacade
     */
    public function __construct(
        CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeInterface $companyBusinessUnitsRestApiFacade
    ) {
        $this->companyBusinessUnitsRestApiFacade = $companyBusinessUnitsRestApiFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapCompanyBusinessUnitToCompanyUser(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        $restCompanyBusinessUnitTransfer = $restCompanyUsersRequestAttributesTransfer->getCompanyBusinessUnit();

        if ($restCompanyBusinessUnitTransfer === null || $restCompanyBusinessUnitTransfer->getExternalReference() === null) {
            return $companyUserTransfer;
        }

        $companyBusinessUnitTransfer = $this->companyBusinessUnitsRestApiFacade
            ->findByExternalReference($restCompanyBusinessUnitTransfer->getExternalReference());

        if ($companyBusinessUnitTransfer === null) {
            return $companyUserTransfer;
        }

        $companyUserTransfer->setCompanyBusinessUnit($companyBusinessUnitTransfer)
            ->setFkCompanyBusinessUnit($companyBusinessUnitTransfer->getIdCompanyBusinessUnit());

        return $companyUserTransfer;
    }
}
