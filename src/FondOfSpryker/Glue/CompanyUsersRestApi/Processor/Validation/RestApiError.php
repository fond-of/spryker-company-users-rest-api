<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Validation;

use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestApiError implements RestApiErrorInterface
{
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
}
