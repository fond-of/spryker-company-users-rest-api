<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Controller;

use ArrayObject;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface getRepository()()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createAction(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        return $this->getFacade()
            ->create($restCompanyUsersRequestAttributesTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function disableCompanyUserAction(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        return $this->getFacade()
            ->disableCompanyUser($companyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findActiveCompanyUsersByCustomerReferenceAction(
        CustomerTransfer $customerTransfer
    ): CompanyUserCollectionTransfer {
        $companyUserCollectionTransfer = new CompanyUserCollectionTransfer();

        if ($customerTransfer->getCustomerReference() === null) {
            return $companyUserCollectionTransfer;
        }

        return $companyUserCollectionTransfer->setCompanyUsers(
            new ArrayObject(
                $this->getRepository()->findActiveCompanyUsersByCustomerReference($customerTransfer->getCustomerReference())
            )
        );
    }
}
