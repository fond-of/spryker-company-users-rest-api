<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Updater;

use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\DeleteCompanyUserPermissionPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\UpdateCompanyUserPermissionPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;

class CompanyUserUpdater implements CompanyUserUpdaterInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface
     */
    protected $companyUserReader;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface
     */
    protected $companyRoleCollectionReader;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyRoleCollectionReaderInterface $companyRoleCollectionReader
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
     */
    public function __construct(
        CompanyUserReaderInterface $companyUserReader,
        CompanyRoleCollectionReaderInterface $companyRoleCollectionReader,
        CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
    ) {
        $this->companyUserReader = $companyUserReader;
        $this->companyRoleCollectionReader = $companyRoleCollectionReader;
        $this->companyUserFacade = $companyUserFacade;
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer
     */
    public function updateByRestWriteCompanyUserRequest(
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): RestWriteCompanyUserResponseTransfer {
        $restWriteCompanyUserResponseTransfer = (new RestWriteCompanyUserResponseTransfer())
            ->setIsSuccess(false);

        $companyUserTransfer = $this->companyUserReader->getCurrentByRestWriteCompanyUserRequest(
            $restWriteCompanyUserRequestTransfer,
        );

        if (
            $companyUserTransfer === null
            || !$this->permissionFacade->can(UpdateCompanyUserPermissionPlugin::KEY, $companyUserTransfer->getIdCompanyUser())
        ) {
            return $restWriteCompanyUserResponseTransfer;
        }

        $companyUserTransfer = $this->companyUserReader->getWriteableByRestWriteCompanyUserRequest(
            $restWriteCompanyUserRequestTransfer,
        );

        if ($companyUserTransfer === null) {
            return $restWriteCompanyUserResponseTransfer;
        }

        $companyRoleCollectionTransfer = $this->companyRoleCollectionReader->getByRestWriteCompanyUserRequest(
            $restWriteCompanyUserRequestTransfer
        );

        $companyUserTransfer = $companyUserTransfer->setCompanyRoleCollection($companyRoleCollectionTransfer);
        $companyUserResponseTransfer = $this->companyUserFacade->update($companyUserTransfer);
        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || !$companyUserResponseTransfer->getIsSuccessful()) {
            return $restWriteCompanyUserResponseTransfer;
        }

        return $restWriteCompanyUserResponseTransfer->setIsSuccess(true)
            ->setCompanyUser($companyUserTransfer);
    }
}
