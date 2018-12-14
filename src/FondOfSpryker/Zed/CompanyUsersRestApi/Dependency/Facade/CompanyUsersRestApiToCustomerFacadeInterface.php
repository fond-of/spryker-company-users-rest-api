<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;

interface CompanyUsersRestApiToCustomerFacadeInterface
{
    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function findByReference(string $reference): ?CustomerTransfer;
}
