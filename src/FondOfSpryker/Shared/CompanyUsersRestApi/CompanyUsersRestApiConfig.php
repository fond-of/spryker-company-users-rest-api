<?php

declare(strict_types=1);

namespace FondOfSpryker\Shared\CompanyUsersRestApi;

class CompanyUsersRestApiConfig
{
    public const RESPONSE_CODE_COMPANY_USER_DATA_INVALID = '1300';
    public const RESPONSE_CODE_COMPANY_NOT_FOUND = '1302';
    public const RESPONSE_CODE_ACCESS_DENIED = '1303';
    public const RESPONSE_CODE_FAILED_DELETING_COMPANY_USER = '1304';
    public const RESPONSE_CODE_COMPANY_USER_ALREADY_EXIST = '1305';

    public const RESPONSE_DETAILS_COMPANY_USER_DATA_INVALID = 'Company user data is invalid.';
    public const RESPONSE_DETAILS_COMPANY_NOT_FOUND = 'Company not found.';
    public const RESPONSE_DETAILS_ACCESS_DENIED = 'Access Denied';
    public const RESPONSE_DETAILS_FAILED_DELETING_COMPANY_USER = 'Could not delete company user.';
    public const RESPONSE_DETAILS_COMPANY_USER_ALREADY_EXIST = 'Company user already exists.';
}
