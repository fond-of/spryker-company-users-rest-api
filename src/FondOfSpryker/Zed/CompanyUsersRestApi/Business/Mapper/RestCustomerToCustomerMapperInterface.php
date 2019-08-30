<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

interface RestCustomerToCustomerMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function mapRestCustomerToCustomer(
        RestCustomerTransfer $restCustomerTransfer,
        CustomerTransfer $customerTransfer
    ): CustomerTransfer;
}
