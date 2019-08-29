<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiEntityManagerInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
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
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface
     */
    protected $companyUsersRestApiRepository;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiEntityManagerInterface $companyUsersRestApiEntityManager
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface $companyUsersRestApiRepository
     */
    public function __construct(
        CompanyUsersRestApiEntityManagerInterface $companyUsersRestApiEntityManager,
        CompanyUsersRestApiRepositoryInterface $companyUsersRestApiRepository
    ) {
        $this->companyUsersRestApiEntityManager = $companyUsersRestApiEntityManager;
        $this->companyUsersRestApiRepository = $companyUsersRestApiRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function delete(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        return $this->getTransactionHandler()->handleTransaction(function () use ($companyUserTransfer) {
            /* @var \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer */
            $dbCompanyUserTransfer = $this->companyUsersRestApiRepository->findCompanyUserByCompanyUserReference(
                $companyUserTransfer->getCompanyUserReference()
            );

            if ($dbCompanyUserTransfer === null) {
                return (new CompanyUserResponseTransfer())->setIsSuccessful(false);
            }

            $this->companyUsersRestApiEntityManager->deleteCompanyUserById($dbCompanyUserTransfer->getIdCompanyUser());

            return (new CompanyUserResponseTransfer())->setIsSuccessful(true);
        });
    }
}
