<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use FondOfSpryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;

class CompanyUsersRestApiToCompanyUserFacadeBridge implements CompanyUsersRestApiToCompanyUserFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface $companyUserFacade
     */
    public function __construct(CompanyUserFacadeInterface $companyUserFacade)
    {
        $this->companyUserFacade = $companyUserFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function create(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        return $this->companyUserFacade->create($companyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function update(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        return $this->companyUserFacade->update($companyUserTransfer);
    }

    /**
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function getCompanyUserByExternalReference(string $externalReference): CompanyUserTransfer
    {
        return $this->companyUserFacade->getCompanyUserByExternalReference($externalReference);
    }
}
