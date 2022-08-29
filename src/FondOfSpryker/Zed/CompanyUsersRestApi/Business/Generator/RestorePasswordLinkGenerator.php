<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator;

use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;

class RestorePasswordLinkGenerator implements RestorePasswordLinkGeneratorInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $config;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig $config
     */
    public function __construct(CompanyUsersRestApiConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $restorePasswordKey
     *
     * @return string
     */
    public function generate(string $restorePasswordKey): string
    {
        return sprintf($this->config->getRestorePasswordLinkFormat(), $restorePasswordKey);
    }
}
