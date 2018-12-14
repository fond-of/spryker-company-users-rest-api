<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use FondOfSpryker\Zed\CompanyBusinessUnitsRestApi\Business\CompanyBusinessUnitsRestApiFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

class CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeBridge implements CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitsRestApi\Business\CompanyBusinessUnitsRestApiFacadeInterface
     */
    protected $companyBusinessUnitsRestApiFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitsRestApi\Business\CompanyBusinessUnitsRestApiFacadeInterface $companyBusinessUnitsRestApiFacade
     */
    public function __construct(CompanyBusinessUnitsRestApiFacadeInterface $companyBusinessUnitsRestApiFacade)
    {
        $this->companyBusinessUnitsRestApiFacade = $companyBusinessUnitsRestApiFacade;
    }

    /**
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function findByExternalReference(string $externalReference): ?CompanyBusinessUnitTransfer
    {
        return $this->companyBusinessUnitsRestApiFacade->findByExternalReference($externalReference);
    }
}
