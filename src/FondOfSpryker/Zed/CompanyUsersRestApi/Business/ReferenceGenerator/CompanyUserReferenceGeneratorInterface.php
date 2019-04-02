<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\ReferenceGenerator;

interface CompanyUserReferenceGeneratorInterface
{
    /**
     * @return string
     */
    public function generateCompanyUserReference(): string;
}
