<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Updater;

use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyUserUpdater implements CompanyUserUpdaterInterface
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface
     */
    protected $restWriteCompanyUserRequestMapper;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected $restResponseBuilder;

    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface
     */
    protected $client;

    /**
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface $restWriteCompanyUserRequestMapper
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface $restResponseBuilder
     * @param \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface $client
     */
    public function __construct(
        RestWriteCompanyUserRequestMapperInterface $restWriteCompanyUserRequestMapper,
        RestResponseBuilderInterface $restResponseBuilder,
        CompanyUsersRestApiClientInterface $client
    ) {
        $this->restWriteCompanyUserRequestMapper = $restWriteCompanyUserRequestMapper;
        $this->restResponseBuilder = $restResponseBuilder;
        $this->client = $client;
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
        $restWriteCompanyUserRequestTransfer = $this->restWriteCompanyUserRequestMapper->fromRestRequest($restRequest)
            ->setRestCompanyUsersRequestAttributes($restCompanyUsersRequestAttributesTransfer);

        $restWriteCompanyUserResponseTransfer = $this->client->updateCompanyUserByRestDeleteCompanyUserRequest(
            $restWriteCompanyUserRequestTransfer,
        );

        $companyUserTransfer = $restWriteCompanyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || $restWriteCompanyUserResponseTransfer->getIsSuccess() !== true) {
            return $this->restResponseBuilder->buildCouldNotUpdateCompanyUserRestResponse();
        }

        return $this->restResponseBuilder->buildRestResponse($companyUserTransfer);
    }
}
