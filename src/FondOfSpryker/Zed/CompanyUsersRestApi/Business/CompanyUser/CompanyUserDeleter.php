<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiEntityManagerInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class CompanyUserDeleter implements CompanyUserDeleterInterface
{
    use TransactionTrait;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiEntityManagerInterface
     */
    protected $companyUsersRestApiEntityManager;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiEntityManagerInterface $companyUsersRestApiEntityManager
     */
    public function __construct(
        CompanyUsersRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade,
        CompanyUsersRestApiEntityManagerInterface $companyUsersRestApiEntityManager
    ) {
        $this->companyUserReferenceFacade = $companyUserReferenceFacade;
        $this->companyUsersRestApiEntityManager = $companyUsersRestApiEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function delete(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        return $this->getTransactionHandler()->handleTransaction(function () use ($companyUserTransfer) {
            $companyUserResponseTransfer = $this->companyUserReferenceFacade->findCompanyUserByCompanyUserReference(
                $companyUserTransfer
            );

            if (!$companyUserResponseTransfer->getIsSuccessful()) {
                return (new CompanyUserResponseTransfer())->setIsSuccessful(false);
            }

            $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

            if ($companyUserTransfer === null || $companyUserTransfer->getIdCompanyUser() === null) {
                return (new CompanyUserResponseTransfer())->setIsSuccessful(false);
            }

            $this->companyUsersRestApiEntityManager->deleteCompanyUserById($companyUserTransfer->getIdCompanyUser());

            return (new CompanyUserResponseTransfer())->setIsSuccessful(true);
        });
    }
}
