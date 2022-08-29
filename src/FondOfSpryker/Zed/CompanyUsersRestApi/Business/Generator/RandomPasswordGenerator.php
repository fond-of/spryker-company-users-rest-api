<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;

class RandomPasswordGenerator implements RandomPasswordGeneratorInterface
{
    /**
     * @var int
     */
    public const PASSWORD_LENGTH = 20;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface
     */
    protected $utilTextService;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface $utilTextService
     */
    public function __construct(CompanyUsersRestApiToUtilTextServiceInterface $utilTextService)
    {
        $this->utilTextService = $utilTextService;
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        return $this->utilTextService->generateRandomString(static::PASSWORD_LENGTH);
    }
}
