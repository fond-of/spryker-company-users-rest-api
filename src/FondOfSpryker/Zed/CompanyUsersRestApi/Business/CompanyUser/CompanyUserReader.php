<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ResponseMessageTransfer;
use Generated\Shared\Transfer\RestCompanyUsersErrorTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Symfony\Component\HttpFoundation\Response;

class CompanyUserReader implements CompanyUserReaderInterface
{
    protected const MESSAGE_COMPANY_USER_NOT_FOUND = 'message.company_user.not_found';

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface
     */
    protected $companyUsersRestApiRepository;

    /**
     * @var \Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface[]
     */
    protected $companyUserHydrationPlugins;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface $companyUsersRestApiRepository
     * @param \Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface[] $companyUserHydrationPlugins
     */
    public function __construct(
        CompanyUsersRestApiRepositoryInterface $companyUsersRestApiRepository,
        array $companyUserHydrationPlugins
    ) {
        $this->companyUsersRestApiRepository = $companyUsersRestApiRepository;
        $this->companyUserHydrationPlugins = $companyUserHydrationPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function findCompanyUserByExternalReference(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        $companyUserTransfer = $this->companyUsersRestApiRepository->findCompanyUserByExternalReference(
            $restCompanyUsersRequestAttributesTransfer->getExternalReference()
        );

        if ($companyUserTransfer !== null) {
            $companyUserTransfer = $this->executeHydrationPlugins($companyUserTransfer);
            return $this->createRestCompanyUsersResponseTransfer($companyUserTransfer);
        }

        return $this->createCompanyUserFailedToLoadErrorResponseTransfer();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected function createRestCompanyUsersResponseTransfer(
        CompanyUserTransfer $companyBusinessUnitTransfer
    ): RestCompanyUsersResponseTransfer {
        $restCompanyUsersResponseAttributesTransfer = new RestCompanyUsersResponseAttributesTransfer();

        $restCompanyUsersResponseAttributesTransfer->fromArray(
            $companyBusinessUnitTransfer->toArray(),
            true
        );

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(true)
            ->setRestCompanyUsersResponseAttributes($restCompanyUsersResponseAttributesTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected function createCompanyUserFailedToLoadErrorResponseTransfer(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_NOT_FOUND)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_USER_NOT_FOUND)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COMPANY_USER_NOT_FOUND);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        $companyUserTransfer = $this->companyUsersRestApiRepository->findCompanyUserByCompanyUserReference(
            $companyUserTransfer->getCompanyUserReference()
        );

        $companyUserResponseTransfer = new CompanyUserResponseTransfer();

        $companyUserResponseTransfer->setIsSuccessful(true)
            ->setCompanyUser($companyUserTransfer);

        if ($companyUserTransfer !== null) {
            $companyUserTransfer = $this->executeHydrationPlugins($companyUserTransfer);
            $companyUserResponseTransfer->setCompanyUser($companyUserTransfer);

            return $companyUserResponseTransfer;
        }

        $companyUserResponseTransfer->setIsSuccessful(false)
            ->addMessage((new ResponseMessageTransfer())->setText(static::MESSAGE_COMPANY_USER_NOT_FOUND));

        return $companyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function executeHydrationPlugins(CompanyUserTransfer $companyUserTransfer): CompanyUserTransfer
    {
        foreach ($this->companyUserHydrationPlugins as $companyUserHydrationPlugin) {
            $companyUserTransfer = $companyUserHydrationPlugin->hydrate($companyUserTransfer);
        }

        return $companyUserTransfer;
    }
}
