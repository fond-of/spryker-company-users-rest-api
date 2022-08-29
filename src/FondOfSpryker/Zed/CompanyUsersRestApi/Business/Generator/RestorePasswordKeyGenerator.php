<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;

class RestorePasswordKeyGenerator implements RestorePasswordKeyGeneratorInterface
{
    /**
     * @var int
     */
    public const RESTORE_PASSWORD_KEY_LENGTH = 32;

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
        return $this->utilTextService->generateRandomString(static::RESTORE_PASSWORD_KEY_LENGTH);
    }
}
