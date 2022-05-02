<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfOryx\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserPermissionPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;

class CompanyUserWriter implements CompanyUserWriterInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface
     */
    protected $customerMapper;

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
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface
     */
    protected $companyUserMapper;

    /**
     * @var \FondOfOryx\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface
     */
    protected $companyUserPluginExecutor;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface
     */
    protected $apiError;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface
     */
    protected $companyUserReader;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $companyUsersRestApiConfig;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface $customerMapper
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface $companyFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface $companyUserMapper
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface $apiError
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig $companyUsersRestApiConfig
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
     * @param \FondOfOryx\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface $companyUserPluginExecutor
     */
    public function __construct(
        CompanyUsersRestApiToCustomerFacadeInterface $customerFacade,
        CustomerMapperInterface $customerMapper,
        CompanyUsersRestApiToCompanyFacadeInterface $companyFacade,
        CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUserMapperInterface $companyUserMapper,
        RestApiErrorInterface $apiError,
        CompanyUserReaderInterface $companyUserReader,
        CompanyUsersRestApiConfig $companyUsersRestApiConfig,
        CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade,
        CompanyUserPluginExecutorInterface $companyUserPluginExecutor
    ) {
        $this->customerFacade = $customerFacade;
        $this->customerMapper = $customerMapper;
        $this->companyFacade = $companyFacade;
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->companyUserFacade = $companyUserFacade;
        $this->companyUserMapper = $companyUserMapper;
        $this->apiError = $apiError;
        $this->companyUserReader = $companyUserReader;
        $this->companyUsersRestApiConfig = $companyUsersRestApiConfig;
        $this->permissionFacade = $permissionFacade;
        $this->companyUserPluginExecutor = $companyUserPluginExecutor;
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

        $companyBusinessUnitTransfer = $this->companyBusinessUnitFacade
            ->findDefaultBusinessUnitByCompanyId($companyTransfer->getIdCompany());

        if ($companyBusinessUnitTransfer === null) {
            return $this->apiError->createDefaultCompanyBusinessUnitNotFoundErrorResponse();
        }

        $customerTransfer = $this->createCustomer($restCompanyUsersRequestAttributesTransfer);

        if ($customerTransfer === null) {
            return $this->apiError->createCouldNotCreateCustomerErrorResponse();
        }

        $companyUserTransfer = $this->buildCompanyUserTransfer(
            $restCompanyUsersRequestAttributesTransfer,
            $companyTransfer,
            $companyBusinessUnitTransfer,
            $customerTransfer
        );

        if ($this->companyUserReader->doesCompanyUserAlreadyExist($companyUserTransfer)) {
            return $this->apiError->createCompanyUserAlreadyExistErrorResponse();
        }

        $companyUserResponseTransfer = $this->companyUserFacade->create($companyUserTransfer);

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->apiError->createCompanyUsersDataInvalidErrorResponse();
        }

        return $this->companyUserPluginExecutor->executePostCreatePlugins(
            $companyUserResponseTransfer->getCompanyUser(),
            $restCompanyUsersRequestAttributesTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function createCustomer(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): ?CustomerTransfer {
        $customerTransfer = $this->customerMapper->mapRestCustomerTransferToCustomerTransfer(
            $restCompanyUsersRequestAttributesTransfer->getCustomer(),
            new CustomerTransfer()
        );

        $customerTransfer = $this->customerFacade->getCustomer($customerTransfer);

        if ($customerTransfer !== null) {
            return $customerTransfer;
        }

        $customerResponseTransfer = $this->customerFacade->addCustomer($customerTransfer);
        if (!$customerResponseTransfer->getIsSuccess()) {
            return null;
        }

        return $customerResponseTransfer->getCustomerTransfer();
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function buildCompanyUserTransfer(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyTransfer $companyTransfer,
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        CustomerTransfer $customerTransfer
    ): CompanyUserTransfer {
        $companyUserTransfer = $this->mapRestCompanyUsersRequestAttributesTransferToCompanyUserTransfer(
            $restCompanyUsersRequestAttributesTransfer
        );

        return $companyUserTransfer->setCompany($companyTransfer)
            ->setFkCompany($companyTransfer->getIdCompany())
            ->setCustomer($customerTransfer)
            ->setFkCustomer($customerTransfer->getIdCustomer())
            ->setCompanyBusinessUnit($companyBusinessUnitTransfer)
            ->setFkCompanyBusinessUnit($companyBusinessUnitTransfer->getIdCompanyBusinessUnit());
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
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function mapRestCompanyUsersRequestAttributesTransferToCompanyUserTransfer(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): CompanyUserTransfer {
        return $this->companyUserMapper->mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer(
            $restCompanyUsersRequestAttributesTransfer,
            new CompanyUserTransfer(),
        );
    }

    /**
     * @param string $companyUuid
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected function findCompanyByUuid(string $companyUuid): CompanyResponseTransfer
    {
        return $this->companyFacade
            ->findCompanyByUuid((new CompanyTransfer())->setUuid($companyUuid));
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return bool
     */
    protected function canCreate(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyTransfer $companyTransfer
    ): bool {
        return true;
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
