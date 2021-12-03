<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestDisableCompanyUserAttributesTransfer;
use Generated\Shared\Transfer\RestDisableCompanyUserRequestAttributesTransfer;
use Spryker\Client\CompanyRole\CompanyRoleClientInterface;
use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserDisabler implements CompanyUserDisablerInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiError;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface
     */
    protected $companyUserClient;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface
     */
    protected $companyUserReferenceClient;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface
     */
    protected $companyUsersMapper;

    /**
     * CompanyUserDisabler constructor.
     *
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface $companyUserClient
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface $companyUserReferenceClient
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface $companyUsersMapper
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface $restApiError
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompanyUsersRestApiToCompanyUserClientInterface $companyUserClient,
        CompanyUsersRestApiToCompanyUserReferenceClientInterface $companyUserReferenceClient,
        CompanyUsersMapperInterface $companyUsersMapper,
        RestApiErrorInterface $restApiError
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->companyUserReferenceClient = $companyUserReferenceClient;
        $this->companyUserClient = $companyUserClient;
        $this->companyUsersMapper = $companyUsersMapper;
        $this->restApiError = $restApiError;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestDisableCompanyUserRequestAttributesTransfer $restDisableCompanyUserRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function disableCompanyUser(
        RestRequestInterface $restRequest,
        RestDisableCompanyUserRequestAttributesTransfer $restDisableCompanyUserRequestAttributesTransfer
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        $companyUserResponseTransfer = $this->companyUserReferenceClient->findCompanyUserByCompanyUserReference(
            (new CompanyUserTransfer())->setCompanyUserReference(
                $restDisableCompanyUserRequestAttributesTransfer->getCompanyUserReference()
            )
        );

        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();
        if ($companyUserTransfer === null || !$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->restApiError->addCompanyUserNotFoundError($restResponse);
        }

        $companyUserResponseTransfer = $this->companyUserClient->disableCompanyUser(
            $companyUserResponseTransfer->getCompanyUser()
        );

        $resource = $this->companyUsersMapper
            ->mapCompanyUsersResource($companyUserResponseTransfer->getCompanyUser())
            ->setPayload($companyUserResponseTransfer->getCompanyUser());

        $restResponse->addResource($resource);

        return $restResponse;
    }
}
