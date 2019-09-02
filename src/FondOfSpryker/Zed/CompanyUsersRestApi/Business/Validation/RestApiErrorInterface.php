<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation;

use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;

interface RestApiErrorInterface
{
    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createCompanyNotFoundErrorResponse(): RestCompanyUsersResponseTransfer;

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createCompanyUserAlreadyExistErrorResponse(): RestCompanyUsersResponseTransfer;

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createDefaultCompanyBusinessUnitNotFoundErrorResponse(): RestCompanyUsersResponseTransfer;

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createCompanyUsersDataInvalidErrorResponse(): RestCompanyUsersResponseTransfer;
}
