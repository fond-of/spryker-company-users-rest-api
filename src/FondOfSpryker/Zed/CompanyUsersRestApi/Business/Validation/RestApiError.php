<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation;

use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\RestCompanyUsersErrorTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Symfony\Component\HttpFoundation\Response;

class RestApiError implements RestApiErrorInterface
{
    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createCompanyNotFoundErrorResponse(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_NOT_FOUND)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COMPANY_NOT_FOUND);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createCompanyUserAlreadyExistErrorResponse(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_USER_ALREADY_EXIST)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COMPANY_USER_ALREADY_EXIST);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createDefaultCompanyBusinessUnitNotFoundErrorResponse(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_NOT_FOUND)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COMPANY_NOT_FOUND);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createCompanyUsersDataInvalidErrorResponse(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_USER_DATA_INVALID)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COMPANY_USER_DATA_INVALID);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createCouldNotCreateCustomerErrorResponse(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COULD_NOT_CREATE_CUSTOMER)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COULD_NOT_CREATE_CUSTOMER);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function createDefaultCompanyRoleNotFoundErrorResponse(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_ROLE_NOT_FOUND)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COMPANY_ROLE_NOT_FOUND);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
    }
}
