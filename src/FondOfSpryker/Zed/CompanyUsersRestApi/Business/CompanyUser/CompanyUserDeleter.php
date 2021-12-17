<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\CompanyUsersRestApiEvents;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToEventInterface;
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
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToEventInterface|null
     */
    protected $eventFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiEntityManagerInterface $companyUsersRestApiEntityManager
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToEventInterface|null $eventFacade
     */
    public function __construct(
        CompanyUsersRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade,
        CompanyUsersRestApiEntityManagerInterface $companyUsersRestApiEntityManager,
        ?CompanyUsersRestApiToEventInterface $eventFacade
    ) {
        $this->companyUserReferenceFacade = $companyUserReferenceFacade;
        $this->companyUsersRestApiEntityManager = $companyUsersRestApiEntityManager;
        $this->eventFacade = $eventFacade;
    }

    /**
     * @deprecated it will be removed in the next updates. Do not use it
     *
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
            $companyUserTransfer->setIsActive(false);

            $this->triggerEvent(
                CompanyUsersRestApiEvents::COMPANY_USER_AFTER_DELETE,
                $companyUserTransfer
            );

            return (new CompanyUserResponseTransfer())->setIsSuccessful(true);
        });
    }

    /**
     * @param string $eventName
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    protected function triggerEvent(string $eventName, CompanyUserTransfer $companyUserTransfer): void
    {
        if ($this->eventFacade === null) {
            return;
        }

        $this->eventFacade->trigger($eventName, $companyUserTransfer);
    }
}
