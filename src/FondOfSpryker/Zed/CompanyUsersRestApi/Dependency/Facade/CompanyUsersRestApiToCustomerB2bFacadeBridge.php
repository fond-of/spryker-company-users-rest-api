<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use FondOfSpryker\Zed\CustomerB2b\Business\CustomerB2bFacadeInterface;
use Generated\Shared\Transfer\CustomerResponseTransfer;

class CompanyUsersRestApiToCustomerB2bFacadeBridge implements CompanyUsersRestApiToCustomerB2bFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\CustomerB2b\Business\CustomerB2bFacadeInterface
     */
    protected $customerB2bFacade;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerB2bFacade
     */
    public function __construct(CustomerB2bFacadeInterface $customerB2bFacade)
    {
        $this->customerB2bFacade = $customerB2bFacade;
    }

    /**
     * @param string $customerExternalReference
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function findCustomerByExternalReference(string $customerExternalReference): CustomerResponseTransfer
    {
        return $this->customerB2bFacade->findCustomerByExternalReference($customerExternalReference);
    }
}
