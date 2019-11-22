<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi;

use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use function sprintf;

class CompanyUsersRestApiConfig extends AbstractBundleConfig
{
    /**
     * @param string $token
     *
     * @return string
     */
    public function getCompanyUserPasswordRestoreTokenUrl(string $token): string
    {
        return sprintf('%s/invite/%s', $this->getHostApp(), $token);
    }

    /**
     * @return string
     */
    public function getHostApp(): string
    {
        return $this->get(CompanyUsersRestApiConstants::BASE_URL_APP);
    }
}
