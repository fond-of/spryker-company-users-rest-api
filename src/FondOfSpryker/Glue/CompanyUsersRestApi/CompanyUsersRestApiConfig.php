<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

class CompanyUsersRestApiConfig
{
    /**
     * @var string
     */
    public const RESOURCE_COMPANY_USERS = 'company-users';

    /**
     * @var string
     */
    public const CONTROLLER_COMPANY_USERS = 'company-users-resource';

    /**
     * @var string
     */
    public const RESOURCE_DISABLE_COMPANY_USER = 'disable-company-user';

    /**
     * @var string
     */
    public const CONTROLLER_DISABLE_COMPANY_USER = 'disable-company-user-resource';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_COULD_NOT_DELETE_COMPANY_USER = 'Could not delete company user.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_COULD_NOT_DELETE_COMPANY_USER = '1001';
}
