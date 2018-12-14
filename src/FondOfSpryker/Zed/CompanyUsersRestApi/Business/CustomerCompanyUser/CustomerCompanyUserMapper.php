<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CustomerCompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class CustomerCompanyUserMapper implements CustomerCompanyUserMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
     */
    public function __construct(CompanyUsersRestApiToCustomerFacadeInterface $customerFacade)
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

        if ($restCustomerTransfer === null || $restCustomerTransfer->getCustomerReference() === null) {
            return $companyUserTransfer;
        }

        $customerTransfer = $this->customerFacade
            ->findByReference($restCustomerTransfer->getCustomerReference());

        if ($customerTransfer !== null) {
            return $companyUserTransfer;
        }

        $companyUserTransfer->setCustomer($customerTransfer)
            ->setFkCustomer($customerTransfer->getIdCustomer());

        return $companyUserTransfer;
    }
}
