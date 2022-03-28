<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use DateTimeImmutable;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\Mail\CompanyUserInviteMailTypePlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserPermissionPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToMailFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;

class CompanyUserWriter implements CompanyUserWriterInterface
{
    /**
     * @var int
     */
    protected const PASSWORD_LENGTH = 20;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface
     */
    protected $restCustomerToCustomerMapper;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
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
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface
     */
    protected $utilTextService;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $companyUsersRestApiConfig;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToMailFacadeInterface
     */
    protected $mailFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCustomerToCustomerMapperInterface $restCustomerToCustomerMapper
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface $companyFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\RestCompanyUserToCompanyUserMapperInterface $restCompanyUserToCompanyUserMapper
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface $apiError
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface $utilTextService
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig $companyUsersRestApiConfig
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToMailFacadeInterface $mailFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
     */
    public function __construct(
        CompanyUsersRestApiToCustomerFacadeInterface $customerFacade,
        RestCustomerToCustomerMapperInterface $restCustomerToCustomerMapper,
        CompanyUsersRestApiToCompanyFacadeInterface $companyFacade,
        CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade,
        RestCompanyUserToCompanyUserMapperInterface $restCompanyUserToCompanyUserMapper,
        RestApiErrorInterface $apiError,
        CompanyUserReaderInterface $companyUserReader,
        CompanyUsersRestApiToUtilTextServiceInterface $utilTextService,
        CompanyUsersRestApiConfig $companyUsersRestApiConfig,
        CompanyUsersRestApiToMailFacadeInterface $mailFacade,
        CompanyUsersRestApiToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
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
        $this->permissionFacade = $permissionFacade;
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
            $restCompanyUsersRequestAttributesTransfer->getCompany()->getIdCompany(),
        );

        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();

        if ($companyTransfer === null || !$companyResponseTransfer->getIsSuccessful()) {
            return $this->apiError->createCompanyNotFoundErrorResponse();
        }

        if (!$this->canCreate($restCompanyUsersRequestAttributesTransfer, $companyTransfer)) {
            return $this->apiError->createAccessDeniedErrorResponse();
        }

        $companyBusinessUnit = $this->findDefaultCompanyBusinessUnitOf($companyTransfer);

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
                $restCompanyUsersRequestAttributesTransfer->getCompanyRole()->getUuid(),
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
            $companyUserResponseTransfer->getCompanyUser(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function disableCompanyUser(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        $companyUserResponseTransfer = $this->companyUserFacade->disableCompanyUser($companyUserTransfer);

        return $companyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
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
                $customerTransfer->getRestorePasswordKey(),
            ),
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
            new CompanyUserTransfer(),
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
            new CustomerTransfer(),
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
            $companyTransfer->getIdCompany(),
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
            true,
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
                (new CompanyRoleCollectionTransfer())->addRole($companyRoleTransfer),
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
            (new CompanyRoleTransfer())->setUuid($companyRoleUuid),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return bool
     */
    protected function canCreate(RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer, CompanyTransfer $companyTransfer): bool
    {
        $idCompany = $companyTransfer->getIdCompany();

        $restCustomerTransfer = $restCompanyUsersRequestAttributesTransfer->getCurrentCustomer();

        if ($idCompany === null || $restCustomerTransfer === null || $restCustomerTransfer->getIdCustomer() === null) {
            return false;
        }

        $companyUserTransfer = $this->companyUserReader->getByIdCustomerAndIdCompany(
            $restCustomerTransfer->getIdCustomer(),
            $idCompany,
        );

        if ($companyUserTransfer === null || $companyUserTransfer->getIdCompanyUser() === null) {
            return false;
        }

        return $this->permissionFacade->can(
            WriteCompanyUserPermissionPlugin::KEY,
            $companyUserTransfer->getIdCompanyUser(),
        );
    }
}
