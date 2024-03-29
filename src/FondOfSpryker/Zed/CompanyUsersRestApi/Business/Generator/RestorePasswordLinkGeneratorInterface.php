<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator;

interface RestorePasswordLinkGeneratorInterface
{
    /**
     * @param string $restorePasswordKey
     *
     * @return string
     */
    public function generate(string $restorePasswordKey): string;
}
