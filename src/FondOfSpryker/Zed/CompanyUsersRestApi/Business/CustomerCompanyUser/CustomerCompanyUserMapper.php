<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CustomerCompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerB2bFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class CustomerCompanyUserMapper implements CustomerCompanyUserMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerB2bFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerB2bFacadeInterface $customerFacade
     */
    public function __construct(CompanyUsersRestApiToCustomerB2bFacadeInterface $customerFacade)
    {
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapCustomerToCompanyUser(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        $restCustomerTransfer = $restCompanyUsersRequestAttributesTransfer->getCustomer();

        if ($restCustomerTransfer === null || $restCustomerTransfer->getExternalReference() === null) {
            return $companyUserTransfer;
        }

        $customerResponseTransfer = $this->customerFacade
            ->findCustomerByExternalReference($restCustomerTransfer->getExternalReference());

        if ($customerResponseTransfer->getIsSuccess() && $customerResponseTransfer->getCustomerTransfer() !== null) {
            $companyUserTransfer->setCustomer($customerResponseTransfer->getCustomerTransfer());
            $companyUserTransfer->setFkCustomer($customerResponseTransfer->getCustomerTransfer()->getIdCustomer());
        }

        return $companyUserTransfer;
    }
}
