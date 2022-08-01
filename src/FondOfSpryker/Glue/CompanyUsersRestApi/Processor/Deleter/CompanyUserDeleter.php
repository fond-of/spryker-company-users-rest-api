<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Deleter;

use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserDeleter implements CompanyUserDeleterInterface
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface
     */
    protected $restDeleteCompanyUserRequestMapper;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected $restResponseBuilder;

    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $client;

    /**
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface $restDeleteCompanyUserRequestMapper
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface $restResponseBuilder
     * @param \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $client
     */
    public function __construct(
        RestDeleteCompanyUserRequestMapperInterface $restDeleteCompanyUserRequestMapper,
        RestResponseBuilderInterface $restResponseBuilder,
        CompanyUsersRestApiClientInterface $client
    ) {
        $this->restDeleteCompanyUserRequestMapper = $restDeleteCompanyUserRequestMapper;
        $this->restResponseBuilder = $restResponseBuilder;
        $this->client = $client;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function delete(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restDeleteCompanyUserRequestTransfer = $this->restDeleteCompanyUserRequestMapper->fromRestRequest($restRequest);

        $restDeleteCompanyUserResponseTransfer = $this->client->deleteCompanyUserByRestDeleteCompanyUserRequest(
            $restDeleteCompanyUserRequestTransfer,
        );

        if ($restDeleteCompanyUserResponseTransfer->getIsSuccess() === false) {
            return $this->restResponseBuilder->buildCouldNotDeleteCompanyUserRestResponse();
        }

        return $this->restResponseBuilder->buildEmptyRestResponse();
    }
}
