<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUsersWriter implements CompanyUsersWriterInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $companyUsersRestApiClient;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiError;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $companyUsersRestApiClient
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface $restApiError
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompanyUsersRestApiClientInterface $companyUsersRestApiClient,
        RestApiErrorInterface $restApiError
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->companyUsersRestApiClient = $companyUsersRestApiClient;
        $this->restApiError = $restApiError;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCompanyUser(
        RestRequestInterface $restRequest,
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestResponseInterface {
        $restCompanyUsersResponseTransfer = $this->companyUsersRestApiClient->create(
            $restCompanyUsersRequestAttributesTransfer
        );

        if (!$restCompanyUsersResponseTransfer->getIsSuccess()) {
            return $this->createSaveCompanyUserFailedErrorResponse($restCompanyUsersResponseTransfer);
        }

        return $this->createCompanyUserSavedResponse($restCompanyUsersResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function createSaveCompanyUserFailedErrorResponse(
        RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        foreach ($restCompanyUsersResponseTransfer->getErrors() as $restCompanyUsersErrorTransfer) {
            $restResponse->addError((new RestErrorMessageTransfer())
                ->setCode($restCompanyUsersErrorTransfer->getCode())
                ->setStatus($restCompanyUsersErrorTransfer->getStatus())
                ->setDetail($restCompanyUsersErrorTransfer->getDetail()));
        }

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function createCompanyUserSavedResponse(RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer): RestResponseInterface
    {
        $restCompanyUsersResponseAttributesTransfer = $restCompanyUsersResponseTransfer->getRestCompanyUsersResponseAttributes();

        $restResource = $this->restResourceBuilder->createRestResource(
            CompanyUsersRestApiConfig::RESOURCE_COMPANY_USERS,
            $restCompanyUsersResponseAttributesTransfer->getUuid(),
            $restCompanyUsersResponseAttributesTransfer
        );

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addResource($restResource);
    }
}
