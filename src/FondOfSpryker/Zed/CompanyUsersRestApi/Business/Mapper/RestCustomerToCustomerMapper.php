<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class RestCustomerToCustomerMapper implements RestCustomerToCustomerMapperInterface
{
    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     */
    public function __construct(CustomerFacadeInterface $customerFacade)
    {
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function mapRestCustomerToCustomer(
        RestCustomerTransfer $restCustomerTransfer,
        CustomerTransfer $customerTransfer
    ): CustomerTransfer {
        return $customerTransfer->fromArray($restCustomerTransfer->toArray(), true);
    }
}
