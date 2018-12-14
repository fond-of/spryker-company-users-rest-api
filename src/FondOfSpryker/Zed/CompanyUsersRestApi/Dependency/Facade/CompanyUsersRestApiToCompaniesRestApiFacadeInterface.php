<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyUsersRestApiToCompaniesRestApiFacadeInterface
{
    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function findByExternalReference(string $reference): ?CompanyTransfer;
}
