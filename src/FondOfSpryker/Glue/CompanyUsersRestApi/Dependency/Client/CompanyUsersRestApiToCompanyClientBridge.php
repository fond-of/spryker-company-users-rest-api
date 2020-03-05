<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Client\Company\CompanyClientInterface;

class CompanyUsersRestApiToCompanyClientBridge implements CompanyUsersRestApiToCompanyClientInterface
{
    /**
     * @var \Spryker\Client\Company\CompanyClientInterface
     */
    private $companyClient;

    /**
     * @param \Spryker\Client\Company\CompanyClientInterface $companyClient
     */
    public function __construct(CompanyClientInterface $companyClient)
    {
        $this->companyClient = $companyClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByUuid(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        return $this->companyClient->findCompanyByUuid($companyTransfer);
    }
}
