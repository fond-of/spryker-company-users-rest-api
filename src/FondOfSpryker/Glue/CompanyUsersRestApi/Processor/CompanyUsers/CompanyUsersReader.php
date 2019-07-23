<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUsersReader implements CompanyUsersReaderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface
     */
    protected $companyUserClient;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface
     */
    protected $companyUserMapper;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiError;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserClientInterface $companyUserClient
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface $companyUserMapper
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface $restApiError
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CompanyUsersRestApiToCompanyUserClientInterface $companyUserClient,
        CompanyUsersMapperInterface $companyUserMapper,
        RestApiErrorInterface $restApiError
    ) {
        $this->companyUserClient = $companyUserClient;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->companyUserMapper = $companyUserMapper;
        $this->restApiError = $restApiError;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function findCurrentCompanyUsers(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();
        $user = $restRequest->getUser();

        if ($user === null) {
            return $this->restApiError->addAccessDeniedError($restResponse);
        }

        $customerTransfer = new CustomerTransfer();
        $customerTransfer->setCustomerReference($user->getNaturalIdentifier());

        $companyUserCollectionTransfer = $this->companyUserClient
            ->getActiveCompanyUsersByCustomerReference($customerTransfer);

        foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUser) {
            $resource = $this->companyUserMapper
                ->mapCompanyUsersResource($companyUser)
                ->setPayload($companyUser);

            $restResponse->addResource($resource);
        }

        return $restResponse;
    }
}
