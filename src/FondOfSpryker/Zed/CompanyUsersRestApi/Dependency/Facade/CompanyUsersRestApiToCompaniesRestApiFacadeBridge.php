<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use FondOfSpryker\Zed\CompaniesRestApi\Business\CompaniesRestApiFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyUsersRestApiToCompaniesRestApiFacadeBridge implements CompanyUsersRestApiToCompaniesRestApiFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompaniesRestApi\Business\CompaniesRestApiFacadeInterface
     */
    protected $companiesRestApiFacade;

    /**
     * @param \FondOfSpryker\Zed\CompaniesRestApi\Business\CompaniesRestApiFacadeInterface $companiesRestApiFacade
     */
    public function __construct(CompaniesRestApiFacadeInterface $companiesRestApiFacade)
    {
        $this->companiesRestApiFacade = $companiesRestApiFacade;
    }

    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function findByExternalReference(string $reference): ?CompanyTransfer
    {
        return $this->companiesRestApiFacade->findByExternalReference($reference);
    }
}
