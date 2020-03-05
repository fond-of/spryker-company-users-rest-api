<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class CompanyUsersDeleter implements CompanyUsersDeleterInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $companyUserClient;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $companyUserClient
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompanyUsersRestApiClientInterface $companyUserClient
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->companyUserClient = $companyUserClient;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function delete(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        $user = $restRequest->getRestUser();
        if ($user === null) {
            return $this->addAccessDeniedError($restResponse);
        }

        $companyUserTransfer = new CompanyUserTransfer();
        $companyUserTransfer->setCompanyUserReference($restRequest->getResource()->getId());

        $companyUserResponseTransfer = $this->companyUserClient->delete($companyUserTransfer);

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->createFailedDeletingCompanyUserError($restResponse);
        }

        return $restResponse;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addAccessDeniedError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_ACCESS_DENIED)
            ->setStatus(Response::HTTP_FORBIDDEN)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_ACCESS_DENIED);

        return $restResponse->addError($restErrorTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function createFailedDeletingCompanyUserError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_FAILED_DELETING_COMPANY_USER)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_FAILED_DELETING_COMPANY_USER);

        return $restResponse->addError($restErrorTransfer);
    }
}
