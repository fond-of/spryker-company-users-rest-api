<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

interface CustomerReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getByRestCustomer(RestCustomerTransfer $restCustomerTransfer): ?CustomerTransfer;
}
