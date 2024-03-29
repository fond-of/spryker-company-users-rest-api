<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service;

interface CompanyUsersRestApiToUtilTextServiceInterface
{
    /**
     * @param int $length
     *
     * @return string
     */
    public function generateRandomString(int $length): string;
}
