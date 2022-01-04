<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Controller;

use Generated\Shared\Transfer\RestDisableCompanyUserRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory getFactory()
 */
class DisableCompanyUserResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "post": {
     *          "summary": [
     *              "Disables Company User"
     *          ],
     *          "parameters": [{
     *              "ref": "acceptLanguage"
     *          }],
     *          "responses": {
     *              "204": "No content."
     *          },
     *          "isEmptyResponse": true
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestDisableCompanyUserRequestAttributesTransfer $restDisableCompanyUserRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(
        RestRequestInterface $restRequest,
        RestDisableCompanyUserRequestAttributesTransfer $restDisableCompanyUserRequestAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createCompanyUsersDisabler()
            ->disableCompanyUser($restRequest, $restDisableCompanyUserRequestAttributesTransfer);
    }
}
