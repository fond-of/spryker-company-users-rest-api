<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Writer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

interface CustomerWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function createByRestCustomer(RestCustomerTransfer $restCustomerTransfer): ?CustomerTransfer;
}
