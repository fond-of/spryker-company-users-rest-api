<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersErrorTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\HttpFoundation\Response;

class CompanyUserWriter implements CompanyUserWriterInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Plugin\CompanyUserMapperPluginInterface[]
     */
    protected $companyUserMapperPlugins;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Plugin\CompanyUserMapperPluginInterface[] $companyUserMapperPlugins
     */
    public function __construct(
        CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade,
        array $companyUserMapperPlugins
    ) {
        $this->companyUserFacade = $companyUserFacade;
        $this->companyUserMapperPlugins = $companyUserMapperPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function create(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        $companyUserTransfer = new CompanyUserTransfer();

        foreach ($this->companyUserMapperPlugins as $companyUserMapperPlugin) {
            $companyUserTransfer = $companyUserMapperPlugin->map(
                $restCompanyUsersRequestAttributesTransfer,
                $companyUserTransfer
            );
        }

        try {
            $companyUserResponseTransfer = $this->companyUserFacade->create($companyUserTransfer);
        } catch (PropelException $e) {
            return $this->createCompanyUsersDataInvalidErrorResponse();
        }

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->createCompanyUsersDataInvalidErrorResponse();
        }

        return $this->createCompanyUsersResponseTransfer(
            $companyUserResponseTransfer->getCompanyUser()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function update(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {

        $restCompanyUsersRequestAttributesTransfer->requireExternalReference();

        $companyUserTransfer = $this->companyUserFacade->getCompanyUserByExternalReference($restCompanyUsersRequestAttributesTransfer->getExternalReference());

        foreach ($this->companyUserMapperPlugins as $companyUserMapperPlugin) {
            $companyUserTransfer = $companyUserMapperPlugin->map(
                $restCompanyUsersRequestAttributesTransfer,
                $companyUserTransfer
            );
        }

        try {
            $companyUserResponseTransfer = $this->companyUserFacade->update($companyUserTransfer);
        } catch (PropelException $e) {
            return $this->createCompanyUsersDataInvalidErrorResponse();
        }

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->createCompanyUsersDataInvalidErrorResponse();
        }

        return $this->createCompanyUsersResponseTransfer(
            $companyUserResponseTransfer->getCompanyUser()
        );
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected function createCompanyUsersDataInvalidErrorResponse(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_USER_DATA_INVALID)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COMPANY_USER_DATA_INVALID);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected function createCompanyUsersResponseTransfer(CompanyUserTransfer $companyUserTransfer): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersResponseAttributesTransfer = new RestCompanyUsersResponseAttributesTransfer();

        $restCompanyUsersResponseAttributesTransfer->fromArray(
            $companyUserTransfer->toArray(),
            true
        );

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(true)
            ->setRestCompanyUsersResponseAttributes($restCompanyUsersResponseAttributesTransfer);

        return $restCompanyUsersResponseTransfer;
    }
}
