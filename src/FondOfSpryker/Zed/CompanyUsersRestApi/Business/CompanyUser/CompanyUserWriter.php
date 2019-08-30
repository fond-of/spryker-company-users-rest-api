<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersErrorTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;
use Symfony\Component\HttpFoundation\Response;

use function count;

class CompanyUserWriter implements CompanyUserWriterInterface
{
    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface
     */
    protected $restCustomerToCustomerMapper;

    /**
     * @var \Spryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @var \Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacade;

    /**
     * @var \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface
     */
    protected $restCompanyUserToCompanyUserMapper;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface $restCustomerToCustomerMapper
     * @param \Spryker\Zed\Company\Business\CompanyFacadeInterface $companyFacade
     * @param \Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface $restCompanyUserToCompanyUserMapper
     */
    public function __construct(
        CustomerFacadeInterface $customerFacade,
        RestCustomerToCustomerMapperInterface $restCustomerToCustomerMapper,
        CompanyFacadeInterface $companyFacade,
        CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        CompanyUserFacadeInterface $companyUserFacade,
        RestCompanyUserToCompanyUserMapperInterface $restCompanyUserToCompanyUserMapper
    ) {
        $this->customerFacade = $customerFacade;
        $this->restCustomerToCustomerMapper = $restCustomerToCustomerMapper;
        $this->companyFacade = $companyFacade;
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->companyUserFacade = $companyUserFacade;
        $this->restCompanyUserToCompanyUserMapper = $restCompanyUserToCompanyUserMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function create(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        $companyResponseTransfer = $this->findCompanyByUuid(
            $restCompanyUsersRequestAttributesTransfer->getCompany()->getIdCompany()
        );

        if (!$companyResponseTransfer->getIsSuccessful()) {
            return $this->createCompanyNotFoundErrorResponse();
        }

        // company business unit will be assigned by a company user before save plugin to avoid duplicate code.
        if (!$this->hasAtLeastOneCompanyBusinessUnit($companyResponseTransfer->getCompanyTransfer())) {
            return $this->createDefaultCompanyBusinessUnitNotFoundErrorResponse();
        }

        // create company user
        $companyUserTransfer = $this->restCompanyUserToCompanyUserMapper->mapRestCompanyUserToCompanyUser(
            $restCompanyUsersRequestAttributesTransfer,
            new CompanyUserTransfer()
        );

        // assign company to company user
        $companyUserTransfer->setCompany($companyResponseTransfer->getCompanyTransfer());
        $companyUserTransfer->setFkCompany($companyResponseTransfer->getCompanyTransfer()->getIdCompany());

        // assign existing customer or create a new customer.
        // new customer will be inserted in companyUserFacade.
        $companyUserTransfer = $this->assignCustomerToCompanyUser(
            $companyUserTransfer,
            $restCompanyUsersRequestAttributesTransfer
        );

        $companyUserResponseTransfer = $this->companyUserFacade->create($companyUserTransfer);

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->createCompanyUsersDataInvalidErrorResponse();
        }

        return $this->createCompanyUsersResponseTransfer(
            $companyUserResponseTransfer->getCompanyUser()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function assignCustomerToCompanyUser(
        CompanyUserTransfer $companyUserTransfer,
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): CompanyUserTransfer {
        $customerTransfer = $this->restCustomerToCustomerMapper->mapRestCustomerToCustomer(
            $restCompanyUsersRequestAttributesTransfer->getCustomer(),
            new CustomerTransfer()
        );

        $companyUserTransfer->setCustomer($customerTransfer);

        return $this->assignCustomerToCompanyUserIfCustomerAlreadyExists($companyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function assignCustomerToCompanyUserIfCustomerAlreadyExists(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        try {
            $customerTransfer = $this->customerFacade->getCustomer($companyUserTransfer->getCustomer());
        } catch (CustomerNotFoundException $e) {
            // customer doesnt exists with email.
            return $companyUserTransfer;
        }

        $companyUserTransfer->setCustomer($customerTransfer);
        $companyUserTransfer->setFkCustomer($customerTransfer->getIdCustomer());

        return $companyUserTransfer;
    }

    /**
     * @param string $companyUuid
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected function findCompanyByUuid(string $companyUuid): CompanyResponseTransfer
    {
        $companyTransfer = new CompanyTransfer();
        $companyTransfer->setUuid($companyUuid);

        return $this->companyFacade->findCompanyByUuid($companyTransfer);
    }

    /**
     * Just check if at least one company business unit exists.
     * Company Business Unit will be assigned by "CompanyBusinessUnitAssigner"
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return bool
     */
    protected function hasAtLeastOneCompanyBusinessUnit(CompanyTransfer $companyTransfer): bool
    {
        $companyBusinessUnitCriteriaFilterTransfer = new CompanyBusinessUnitCriteriaFilterTransfer();
        $companyBusinessUnitCriteriaFilterTransfer->setIdCompany($companyTransfer->getIdCompany());

        $companyBusinessUnitCollectionTransfer = $this->companyBusinessUnitFacade->getCompanyBusinessUnitCollection(
            $companyBusinessUnitCriteriaFilterTransfer
        );

        return count($companyBusinessUnitCollectionTransfer->getCompanyBusinessUnits()) > 0;
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected function createCompanyNotFoundErrorResponse(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_NOT_FOUND)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COMPANY_NOT_FOUND);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected function createDefaultCompanyBusinessUnitNotFoundErrorResponse(): RestCompanyUsersResponseTransfer
    {
        $restCompanyUsersErrorTransfer = new RestCompanyUsersErrorTransfer();

        $restCompanyUsersErrorTransfer->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setCode(CompanyUsersRestApiConfig::RESPONSE_CODE_COMPANY_NOT_FOUND)
            ->setDetail(CompanyUsersRestApiConfig::RESPONSE_DETAILS_COMPANY_NOT_FOUND);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(false)
            ->addError($restCompanyUsersErrorTransfer);

        return $restCompanyUsersResponseTransfer;
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
