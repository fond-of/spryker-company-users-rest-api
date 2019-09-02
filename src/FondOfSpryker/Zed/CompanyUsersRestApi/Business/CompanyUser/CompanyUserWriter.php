<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;

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
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface
     */
    protected $apiError;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface
     */
    protected $companyUserReader;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface $restCustomerToCustomerMapper
     * @param \Spryker\Zed\Company\Business\CompanyFacadeInterface $companyFacade
     * @param \Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface $restCompanyUserToCompanyUserMapper
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface $apiError
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface $companyUserReader
     */
    public function __construct(
        CustomerFacadeInterface $customerFacade,
        RestCustomerToCustomerMapperInterface $restCustomerToCustomerMapper,
        CompanyFacadeInterface $companyFacade,
        CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        CompanyUserFacadeInterface $companyUserFacade,
        RestCompanyUserToCompanyUserMapperInterface $restCompanyUserToCompanyUserMapper,
        RestApiErrorInterface $apiError,
        CompanyUserReaderInterface $companyUserReader
    ) {
        $this->customerFacade = $customerFacade;
        $this->restCustomerToCustomerMapper = $restCustomerToCustomerMapper;
        $this->companyFacade = $companyFacade;
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->companyUserFacade = $companyUserFacade;
        $this->restCompanyUserToCompanyUserMapper = $restCompanyUserToCompanyUserMapper;
        $this->apiError = $apiError;
        $this->companyUserReader = $companyUserReader;
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
            return $this->apiError->createCompanyNotFoundErrorResponse();
        }

        $companyBusinessUnit = $this->findDefaultCompanyBusinessUnitOf($companyResponseTransfer->getCompanyTransfer());

        if ($companyBusinessUnit === null) {
            return $this->apiError->createDefaultCompanyBusinessUnitNotFoundErrorResponse();
        }

        $customerTransfer = $this->findOrCreateCustomerTransferFrom($restCompanyUsersRequestAttributesTransfer);

        $companyUserTransfer = $this->createCompanyUser($restCompanyUsersRequestAttributesTransfer);
        $companyUserTransfer = $this->assignCompanyTo($companyUserTransfer, $companyResponseTransfer->getCompanyTransfer());
        $companyUserTransfer = $this->assignCompanyBusinessUnitTo($companyUserTransfer, $companyBusinessUnit);
        $companyUserTransfer = $this->assignCustomerTo($companyUserTransfer, $customerTransfer);

        if ($this->companyUserReader->doesCompanyUserAlreadyExist($companyUserTransfer)) {
            return $this->apiError->createCompanyUserAlreadyExistErrorResponse();
        }

        $companyUserResponseTransfer = $this->companyUserFacade->create($companyUserTransfer);

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->apiError->createCompanyUsersDataInvalidErrorResponse();
        }

        return $this->createCompanyUsersResponseTransfer(
            $companyUserResponseTransfer->getCompanyUser()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function createCompanyUser(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): CompanyUserTransfer {
        return $this->restCompanyUserToCompanyUserMapper->mapRestCompanyUserToCompanyUser(
            $restCompanyUsersRequestAttributesTransfer,
            new CompanyUserTransfer()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function assignCompanyTo(
        CompanyUserTransfer $companyUserTransfer,
        CompanyTransfer $companyTransfer
    ): CompanyUserTransfer {
        $companyUserTransfer->setCompany($companyTransfer);
        $companyUserTransfer->setFkCompany($companyTransfer->getIdCompany());

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function assignCustomerTo(
        CompanyUserTransfer $companyUserTransfer,
        CustomerTransfer $customerTransfer
    ): CompanyUserTransfer {
        $companyUserTransfer->setCustomer($customerTransfer);

        if ($customerTransfer->getIdCustomer() !== null) {
            $companyUserTransfer->setFkCustomer($customerTransfer->getIdCustomer());
        }

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function assignCompanyBusinessUnitTo(
        CompanyUserTransfer $companyUserTransfer,
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyUserTransfer {
        $companyUserTransfer->setCompanyBusinessUnit($companyBusinessUnitTransfer);
        $companyUserTransfer->setFkCompanyBusinessUnit($companyBusinessUnitTransfer->getIdCompanyBusinessUnit());

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function findOrCreateCustomerTransferFrom(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): CustomerTransfer {
        $customerTransfer = $this->restCustomerToCustomerMapper->mapRestCustomerToCustomer(
            $restCompanyUsersRequestAttributesTransfer->getCustomer(),
            new CustomerTransfer()
        );

        try {
            return $this->customerFacade->getCustomer($customerTransfer);
        } catch (CustomerNotFoundException $ex) {
            // customer does not exist in db.
            return $customerTransfer;
        }
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
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    protected function findDefaultCompanyBusinessUnitOf(CompanyTransfer $companyTransfer): ?CompanyBusinessUnitTransfer
    {
        return $this->companyBusinessUnitFacade->findDefaultBusinessUnitByCompanyId(
            $companyTransfer->getIdCompany()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected function createCompanyUsersResponseTransfer(
        CompanyUserTransfer $companyUserTransfer
    ): RestCompanyUsersResponseTransfer {
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
