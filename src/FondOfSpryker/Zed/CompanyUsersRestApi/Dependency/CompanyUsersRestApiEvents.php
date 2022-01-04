<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency;

interface CompanyUsersRestApiEvents
{
    public const COMPANY_USER_AFTER_DELETE = 'company_user.after.delete';
    public const ENTITY_SPY_COMPANY_USER_UPDATE = 'Entity.spy_company_user.update';
}
