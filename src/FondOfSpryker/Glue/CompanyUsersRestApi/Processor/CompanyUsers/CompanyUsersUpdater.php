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
use Spryker\Client\CompanyRole\CompanyRoleClientInterface;
use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUsersUpdater implements CompanyUsersUpdaterInterface
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
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface
     */
    protected $companyUserClient;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface
     */
    protected $companyUserReferenceClient;

    /**
     * @var \Spryker\Client\CompanyRole\CompanyRoleClientInterface
     */
    protected $companyRoleClient;

    /**
     * @var \Spryker\Client\Customer\CustomerClientInterface
     */
    protected $customerClient;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface
     */
    protected $companyUsersMapper;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $companyUsersRestApiClient
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface $restApiError
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface $companyUserClient
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface $companyUserReferenceClient
     * @param \Spryker\Client\CompanyRole\CompanyRoleClientInterface $companyRoleClient
     * @param \Spryker\Client\Customer\CustomerClientInterface $customerClient
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface $companyUsersMapper
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompanyUsersRestApiClientInterface $companyUsersRestApiClient,
        RestApiErrorInterface $restApiError,
        CompanyUsersRestApiToCompanyUserClientInterface $companyUserClient,
        CompanyUsersRestApiToCompanyUserReferenceClientInterface $companyUserReferenceClient,
        CompanyRoleClientInterface $companyRoleClient,
        CustomerClientInterface $customerClient,
        CompanyUsersMapperInterface $companyUsersMapper
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->companyUsersRestApiClient = $companyUsersRestApiClient;
        $this->restApiError = $restApiError;
        $this->companyUserClient = $companyUserClient;
        $this->companyUserReferenceClient = $companyUserReferenceClient;
        $this->companyRoleClient = $companyRoleClient;
        $this->customerClient = $customerClient;
        $this->companyUsersMapper = $companyUsersMapper;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function update(
        RestRequestInterface $restRequest,
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        $companyRoleResponseTransfer = $this->companyRoleClient->findCompanyRoleByUuid(
            (new CompanyRoleTransfer())->setUuid(
                $restCompanyUsersRequestAttributesTransfer->getCompanyRole()->getUuid()
            )
        );

        if (!$companyRoleResponseTransfer->getIsSuccessful()) {
            return $this->restApiError->addCompanyRoleNotFoundError($restResponse);
        }

        $companyUserResponseTransfer = $this->companyUserReferenceClient->findCompanyUserByCompanyUserReference(
            (new CompanyUserTransfer())->setCompanyUserReference(
                $restRequest->getResource()->getId()
            )
        );

        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();
        if ($companyUserTransfer === null || !$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->restApiError->addCompanyUserNotFoundError($restResponse);
        }

        $companyUserTransfer = $companyUserTransfer
            ->fromArray($restCompanyUsersRequestAttributesTransfer->modifiedToArray());
        $companyUserTransfer = $this->assignCustomer($companyUserTransfer);
        $companyUserTransfer = $this->assignCompanyRole($companyUserTransfer, $companyRoleResponseTransfer->getCompanyRoleTransfer());
        
        $companyUserResponseTransfer = $this->companyUserClient->updateCompanyUser($companyUserTransfer);

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->restApiError->addCompanyUserNotFoundError($restResponse);
        }

        $resource = $this->companyUsersMapper
            ->mapCompanyUsersResource($companyUserResponseTransfer->getCompanyUser())
            ->setPayload($companyUserResponseTransfer->getCompanyUser());

        $restResponse->addResource($resource);

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function assignCompanyRole(
        CompanyUserTransfer $companyUserTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): CompanyUserTransfer {
        $companyRoleCollection = new CompanyRoleCollectionTransfer();
        $companyRoleCollection->addRole($companyRoleTransfer);

        $companyUserTransfer->setCompanyRoleCollection($companyRoleCollection);

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function assignCustomer(CompanyUserTransfer $companyUserTransfer): CompanyUserTransfer
    {
        $companyUserTransfer->setCustomer(
            $this->customerClient->getCustomerById($companyUserTransfer->getFkCustomer())
        );

        return $companyUserTransfer;
    }
}
