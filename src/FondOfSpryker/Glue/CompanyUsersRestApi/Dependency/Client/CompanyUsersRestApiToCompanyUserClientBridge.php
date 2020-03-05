<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\CompanyUser\CompanyUserClientInterface;

class CompanyUsersRestApiToCompanyUserClientBridge implements CompanyUsersRestApiToCompanyUserClientInterface
{
    /**
     * @var \Spryker\Client\CompanyUser\CompanyUserClientInterface
     */
    protected $companyUserClient;

    /**
     * @param \Spryker\Client\CompanyUser\CompanyUserClientInterface $companyUserClient
     */
    public function __construct(CompanyUserClientInterface $companyUserClient)
    {
        $this->companyUserClient = $companyUserClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function getActiveCompanyUsersByCustomerReference(
        CustomerTransfer $customerTransfer
    ): CompanyUserCollectionTransfer {
        return $this->companyUserClient->getActiveCompanyUsersByCustomerReference($customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function updateCompanyUser(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        return $this->companyUserClient->updateCompanyUser($companyUserTransfer);
    }
}
