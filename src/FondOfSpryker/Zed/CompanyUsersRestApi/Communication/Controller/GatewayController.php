<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Controller;

use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createAction(RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer): RestCompanyUsersResponseTransfer
    {
        return $this->getFacade()->create($restCompanyUsersRequestAttributesTransfer);
    }
}
