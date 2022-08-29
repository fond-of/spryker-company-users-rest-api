<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi;

use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use function sprintf;

/**
 * @codeCoverageIgnore
 */
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
        return $this->get(CompanyUsersRestApiConstants::BASE_URI);
    }

    /**
     * @return string
     */
    public function getRestorePasswordLinkFormat(): string
    {
        return sprintf('%sinvite/%%s', $this->getBaseUri());
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->get(CompanyUsersRestApiConstants::BASE_URI, 'http://127.0.0.1/');
    }
}
