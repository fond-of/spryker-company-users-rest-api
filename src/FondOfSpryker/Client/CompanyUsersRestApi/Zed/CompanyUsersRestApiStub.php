<?php

declare(strict_types=1);

namespace FondOfSpryker\Client\CompanyUsersRestApi\Zed;

use FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;

class CompanyUsersRestApiStub implements CompanyUsersRestApiStubInterface
{
    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfSpryker\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CompanyUsersRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        /** @var \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer */
        $companyUserResponseTransfer = $this->zedRequestClient->call(
            '/company-users-rest-api/gateway/find-company-user-by-company-user-reference',
            $companyUserTransfer
        );

        return $companyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function create(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer */
        $restCompanyUsersResponseTransfer = $this->zedRequestClient->call(
            '/company-users-rest-api/gateway/create',
            $restCompanyUsersRequestAttributesTransfer
        );

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function delete(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer */
        $companyUserResponseTransfer = $this->zedRequestClient->call(
            '/company-users-rest-api/gateway/delete',
            $companyUserTransfer
        );

        return $companyUserResponseTransfer;
    }
}
