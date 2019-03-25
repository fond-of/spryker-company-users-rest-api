<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersErrorTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Symfony\Component\HttpFoundation\Response;

class CompanyUserReader implements CompanyUserReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface
     */
    protected $companyUsersRestApiRepository;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface $companyUsersRestApiRepository
     */
    public function __construct(CompanyUsersRestApiRepositoryInterface $companyUsersRestApiRepository)
    {
        $this->companyUsersRestApiRepository = $companyUsersRestApiRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function findCompanyUserByExternalReference(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        $companyBusinessUnitTransfer = $this->companyUsersRestApiRepository->findCompanyUserByExternalReference(
            $restCompanyUsersRequestAttributesTransfer->getExternalReference()
        );

        if ($companyBusinessUnitTransfer !== null) {
            return $this->createCompanyUserResponseTransfer($companyBusinessUnitTransfer);
        }

        return $this->createCompanyUserFailedToLoadErrorResponseTransfer();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected function createCompanyUserResponseTransfer(
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
}
