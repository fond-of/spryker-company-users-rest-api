<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use DateTimeImmutable;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\Mail\CompanyUserInviteMailTypePlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\Mail\Business\MailFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Spryker\Service\UtilText\UtilTextServiceInterface;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;

class CompanyUserWriter implements CompanyUserWriterInterface
{
    protected const PASSWORD_LENGTH = 20;

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
     * @var \Spryker\Service\UtilText\UtilTextServiceInterface
     */
    protected $utilTextService;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $companyUsersRestApiConfig;

    /**
     * @var \FondOfSpryker\Zed\Mail\Business\MailFacadeInterface
     */
    protected $mailFacade;

    /**
     * @var \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface $restCustomerToCustomerMapper
     * @param \Spryker\Zed\Company\Business\CompanyFacadeInterface $companyFacade
     * @param \Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface $restCompanyUserToCompanyUserMapper
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface $apiError
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface $companyUserReader
     * @param \Spryker\Service\UtilText\UtilTextServiceInterface $utilTextService
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig $companyUsersRestApiConfig
     * @param \FondOfSpryker\Zed\Mail\Business\MailFacadeInterface $mailFacade
     * @param \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct(
        CustomerFacadeInterface $customerFacade,
        RestCustomerToCustomerMapperInterface $restCustomerToCustomerMapper,
        CompanyFacadeInterface $companyFacade,
        CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        CompanyUserFacadeInterface $companyUserFacade,
        RestCompanyUserToCompanyUserMapperInterface $restCompanyUserToCompanyUserMapper,
        RestApiErrorInterface $apiError,
        CompanyUserReaderInterface $companyUserReader,
        UtilTextServiceInterface $utilTextService,
        CompanyUsersRestApiConfig $companyUsersRestApiConfig,
        MailFacadeInterface $mailFacade,
        CompanyRoleFacadeInterface $companyRoleFacade
    ) {
        $this->customerFacade = $customerFacade;
        $this->restCustomerToCustomerMapper = $restCustomerToCustomerMapper;
        $this->companyFacade = $companyFacade;
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->companyUserFacade = $companyUserFacade;
        $this->restCompanyUserToCompanyUserMapper = $restCompanyUserToCompanyUserMapper;
        $this->apiError = $apiError;
        $this->companyUserReader = $companyUserReader;
        $this->utilTextService = $utilTextService;
        $this->companyUsersRestApiConfig = $companyUsersRestApiConfig;
        $this->mailFacade = $mailFacade;
        $this->companyRoleFacade = $companyRoleFacade;
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

        $filterCustomerTransfer = $this->createCustomerTransferFrom($restCompanyUsersRequestAttributesTransfer);
        $customerTransfer = $this->findCustomerTransferFrom($filterCustomerTransfer);

        $sendPasswordRestoreMail = false;
        if ($customerTransfer === null) {
            $customerTransfer = $this->createCustomer($filterCustomerTransfer);
            $sendPasswordRestoreMail = true;
        }

        if ($customerTransfer === null) {
            return $this->apiError->createCouldNotCreateCustomerErrorResponse();
        }

        $companyRole = null;
        if ($restCompanyUsersRequestAttributesTransfer->getCompanyRole() !== null) {
            $companyRoleResponseTransfer = $this->findCompanyRoleBy(
                $restCompanyUsersRequestAttributesTransfer->getCompanyRole()->getUuid()
            );

            if (!$companyRoleResponseTransfer->getIsSuccessful()) {
                return $this->apiError->createDefaultCompanyRoleNotFoundErrorResponse();
            }

            $companyRoleCompanyId = $companyRoleResponseTransfer->getCompanyRoleTransfer()->getFkCompany();
            $companyId = $companyResponseTransfer->getCompanyTransfer()->getIdCompany();

            if ($companyRoleCompanyId !== $companyId) {
                return $this->apiError->createDefaultCompanyRoleNotFoundErrorResponse();
            }

            $companyRole = $companyRoleResponseTransfer->getCompanyRoleTransfer();
        }

        $companyUserTransfer = $this->createCompanyUser($restCompanyUsersRequestAttributesTransfer);
        $companyUserTransfer = $this->assignCompanyTo($companyUserTransfer, $companyResponseTransfer->getCompanyTransfer());
        $companyUserTransfer = $this->assignCompanyBusinessUnitTo($companyUserTransfer, $companyBusinessUnit);
        $companyUserTransfer = $this->assignCustomerTo($companyUserTransfer, $customerTransfer);
        $companyUserTransfer = $this->assignCompanyRoleIfExistsTo($companyUserTransfer, $companyRole);

        if ($this->companyUserReader->doesCompanyUserAlreadyExist($companyUserTransfer)) {
            return $this->apiError->createCompanyUserAlreadyExistErrorResponse();
        }

        $companyUserResponseTransfer = $this->companyUserFacade->create($companyUserTransfer);

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->apiError->createCompanyUsersDataInvalidErrorResponse();
        }

        // only send company user invitation mail if customer is new
        if ($sendPasswordRestoreMail === true) {
            $this->sendCompanyUserInviteMail($customerTransfer);
        }

        return $this->createCompanyUsersResponseTransfer(
            $companyUserResponseTransfer->getCompanyUser()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @throws
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function createCustomerRestorePasswordProperties(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        $customerTransfer->setPassword($this->generateRandomCustomerPassword());
        $customerTransfer->setRestorePasswordDate(new DateTimeImmutable());
        $customerTransfer->setRestorePasswordKey($this->generateKey());
        $customerTransfer->setRestorePasswordLink(
            $this->companyUsersRestApiConfig->getCompanyUserPasswordRestoreTokenUrl(
                $customerTransfer->getRestorePasswordKey()
            )
        );

        return $customerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function sendCompanyUserInviteMail(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        $mailTransfer = new MailTransfer();
        $mailTransfer->setType(CompanyUserInviteMailTypePlugin::MAIL_TYPE);
        $mailTransfer->setCustomer($customerTransfer);
        $mailTransfer->setLocale($customerTransfer->getLocale());

        $this->mailFacade->handleMail($mailTransfer);

        return $customerTransfer;
    }

    /**
     * @return string
     */
    protected function generateKey(): string
    {
        return $this->utilTextService->generateRandomString(32);
    }

    /**
     * @return string
     */
    protected function generateRandomCustomerPassword(): string
    {
        return $this->utilTextService->generateRandomString(static::PASSWORD_LENGTH);
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
        $companyUserTransfer->setFkCustomer($customerTransfer->getIdCustomer());

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
    protected function createCustomerTransferFrom(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): CustomerTransfer {
        return $this->restCustomerToCustomerMapper->mapRestCustomerToCustomer(
            $restCompanyUsersRequestAttributesTransfer->getCustomer(),
            new CustomerTransfer()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function findCustomerTransferFrom(
        CustomerTransfer $customerTransfer
    ): ?CustomerTransfer {
        try {
            return $this->customerFacade->getCustomer($customerTransfer);
        } catch (CustomerNotFoundException $ex) {
            return null;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function createCustomer(CustomerTransfer $customerTransfer): ?CustomerTransfer
    {
        $customerTransfer = $this->createCustomerRestorePasswordProperties($customerTransfer);

        $customerResponseTransfer = $this->customerFacade->addCustomer($customerTransfer);

        if (!$customerResponseTransfer->getIsSuccess()) {
            return null;
        }

        return $customerResponseTransfer->getCustomerTransfer();
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
            ->setRestCompanyUsersResponseAttributes($restCompanyUsersResponseAttributesTransfer)
            ->setCompanyUser($companyUserTransfer);

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer|null $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function assignCompanyRoleIfExistsTo(
        CompanyUserTransfer $companyUserTransfer,
        ?CompanyRoleTransfer $companyRoleTransfer = null
    ): CompanyUserTransfer {
        if ($companyRoleTransfer !== null) {
            $companyUserTransfer->setCompanyRoleCollection(
                (new CompanyRoleCollectionTransfer())->addRole($companyRoleTransfer)
            );
        }

        return $companyUserTransfer;
    }

    /**
     * @param string $companyRoleUuid
     *
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected function findCompanyRoleBy(string $companyRoleUuid): CompanyRoleResponseTransfer
    {
        return $this->companyRoleFacade->findCompanyRoleByUuid(
            (new CompanyRoleTransfer())->setUuid($companyRoleUuid)
        );
    }
}
