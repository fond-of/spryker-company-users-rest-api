<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Deleter;

use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\DeleteCompanyUserPermissionPlugin;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;

class CompanyUserDeleter implements CompanyUserDeleterInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface
     */
    protected $companyUserReader;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
     */
    public function __construct(
        CompanyUserReaderInterface $companyUserReader,
        CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
    ) {
        $this->companyUserReader = $companyUserReader;
        $this->companyUserFacade = $companyUserFacade;
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer
     */
    public function deleteByRestDeleteCompanyUserRequest(
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): RestDeleteCompanyUserResponseTransfer {
        $restDeleteCompanyUserResponseTransfer = (new RestDeleteCompanyUserResponseTransfer())
            ->setIsSuccess(false);

        $companyUserTransfer = $this->companyUserReader->getCurrentByRestDeleteCompanyUserRequest(
            $restDeleteCompanyUserRequestTransfer,
        );

        if (
            $companyUserTransfer === null
            || !$this->permissionFacade->can(DeleteCompanyUserPermissionPlugin::KEY, $companyUserTransfer->getIdCompanyUser())
        ) {
            return $restDeleteCompanyUserResponseTransfer;
        }

        $companyUserTransfer = $this->companyUserReader->getDeletableByRestDeleteCompanyUserRequest(
            $restDeleteCompanyUserRequestTransfer,
        );

        if ($companyUserTransfer === null) {
            return $restDeleteCompanyUserResponseTransfer;
        }

        $companyUserResponseTransfer = $this->companyUserFacade->deleteCompanyUser($companyUserTransfer);

        return $restDeleteCompanyUserResponseTransfer->setIsSuccess($companyUserResponseTransfer->getIsSuccessful());
    }
}
