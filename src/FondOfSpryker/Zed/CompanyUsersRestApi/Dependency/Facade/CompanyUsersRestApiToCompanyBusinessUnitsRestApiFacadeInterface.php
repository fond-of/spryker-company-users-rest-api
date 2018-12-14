<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface CompanyUsersRestApiToCompanyBusinessUnitsRestApiFacadeInterface
{
    /**
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function findByExternalReference(string $externalReference): ?CompanyBusinessUnitTransfer;
}
