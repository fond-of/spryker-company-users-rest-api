<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use FondOfSpryker\Client\CompanyUserPermission\Plugin\Permission\WriteCompanyUserPermissionPlugin;
use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\PermissionAwareTrait;

class CompanyUsersWriter implements CompanyUsersWriterInterface
{
    use PermissionAwareTrait;

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
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientInterface
     */
    protected $companyClient;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $companyUsersRestApiClient
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientInterface $companyClient
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface $restApiError
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompanyUsersRestApiClientInterface $companyUsersRestApiClient,
        CompanyUsersRestApiToCompanyClientInterface $companyClient,
        RestApiErrorInterface $restApiError
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->companyUsersRestApiClient = $companyUsersRestApiClient;
        $this->restApiError = $restApiError;
        $this->companyClient = $companyClient;
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
        $companyTransfer = $this->getCompanyByRestCompanyUsersRequestAttributesTransfer(
            $restCompanyUsersRequestAttributesTransfer
        );

        if ($companyTransfer === null || $companyTransfer->getIdCompany() === null) {
            return $this->restApiError->addAccessDeniedError($this->restResourceBuilder->createRestResponse());
        }

        $hasPermissionToWrite = $this->can(
            WriteCompanyUserPermissionPlugin::KEY,
            $companyTransfer->getIdCompany()
        );

        if (!$hasPermissionToWrite) {
            return $this->restApiError->addAccessDeniedError($this->restResourceBuilder->createRestResponse());
        }

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
        /** @var \Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer $restCompanyUsersResponseAttributesTransfer */
        $restCompanyUsersResponseAttributesTransfer = $restCompanyUsersResponseTransfer->getRestCompanyUsersResponseAttributes();

        $restResource = $this->restResourceBuilder->createRestResource(
            CompanyUsersRestApiConfig::RESOURCE_COMPANY_USERS,
            $restCompanyUsersResponseAttributesTransfer->getCompanyUserReference(),
            $restCompanyUsersResponseAttributesTransfer
        )->setPayload($restCompanyUsersResponseTransfer->getCompanyUser());

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addResource($restResource);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    protected function getCompanyByRestCompanyUsersRequestAttributesTransfer(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): ?CompanyTransfer {
        $restCompanyTransfer = $restCompanyUsersRequestAttributesTransfer->getCompany();

        if ($restCompanyTransfer === null || $restCompanyTransfer->getIdCompany() === null) {
            return null;
        }

        $companyTransfer = (new CompanyTransfer())->setUuid($restCompanyTransfer->getIdCompany());

        $companyResponseTransfer = $this->companyClient->findCompanyByUuid($companyTransfer);

        return $companyResponseTransfer->getCompanyTransfer();
    }
}
