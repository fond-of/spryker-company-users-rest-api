<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader;

use Exception;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CustomerReader implements CustomerReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface
     */
    protected $customerMapper;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface $customerMapper
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
     */
    public function __construct(
        CustomerMapperInterface $customerMapper,
        CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
    ) {
        $this->customerMapper = $customerMapper;
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getByRestCustomer(RestCustomerTransfer $restCustomerTransfer): ?CustomerTransfer
    {
        $customerTransfer = $this->customerMapper->fromRestCustomer($restCustomerTransfer);

        try {
            return $this->customerFacade->getCustomer($customerTransfer);
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getByRestCompanyUsersRequestAttributes(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): ?CustomerTransfer {
        $restCustomerTransfer = $restCompanyUsersRequestAttributesTransfer->getCustomer();

        if ($restCustomerTransfer === null) {
            return null;
        }

        return $this->getByRestCustomer($restCustomerTransfer);
    }
}
