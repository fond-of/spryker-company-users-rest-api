<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyUsersRestApiToPermissionFacadeBridge implements CompanyUsersRestApiToPermissionFacadeInterface
{
    /**
     * @var \Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \Spryker\Zed\Permission\Business\PermissionFacadeInterface $permissionFacade
     */
    public function __construct(PermissionFacadeInterface $permissionFacade)
    {
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param string $permissionKey
     * @param int|string $identifier
     * @param null $context
     *
     * @return bool
     */
    public function can(string $permissionKey, $identifier, $context = null): bool
    {
        return $this->permissionFacade->can($permissionKey, $identifier, $context);
    }
}