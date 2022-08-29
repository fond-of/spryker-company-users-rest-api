<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator;

interface RandomPasswordGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string;
}
