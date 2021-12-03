<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers;

use Generated\Shared\Transfer\RestDisableCompanyUserAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface CompanyUserDisablerInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestDisableCompanyUserAttributesTransfer $restDisableCompanyUserAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function disableCompanyUser(
        RestRequestInterface $restRequest,
        RestDisableCompanyUserAttributesTransfer $restDisableCompanyUserAttributesTransfer
    ): RestResponseInterface;
}
