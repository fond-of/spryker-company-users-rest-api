<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ResponseMessageTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    protected const MESSAGE_COMPANY_USER_NOT_FOUND = 'message.company_user.not_found';

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface
     */
    protected $companyUsersRestApiRepository;

    /**
     * @var \Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface[]
     */
    protected $companyUserHydrationPlugins;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface $companyUsersRestApiRepository
     * @param \Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface[] $companyUserHydrationPlugins
     */
    public function __construct(
        CompanyUsersRestApiRepositoryInterface $companyUsersRestApiRepository,
        array $companyUserHydrationPlugins
    ) {
        $this->companyUsersRestApiRepository = $companyUsersRestApiRepository;
        $this->companyUserHydrationPlugins = $companyUserHydrationPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        $companyUserTransfer = $this->companyUsersRestApiRepository->findCompanyUserByCompanyUserReference(
            $companyUserTransfer->getCompanyUserReference()
        );

        $companyUserResponseTransfer = new CompanyUserResponseTransfer();

        $companyUserResponseTransfer->setIsSuccessful(true)
            ->setCompanyUser($companyUserTransfer);

        if ($companyUserTransfer !== null) {
            $companyUserTransfer = $this->executeHydrationPlugins($companyUserTransfer);
            $companyUserResponseTransfer->setCompanyUser($companyUserTransfer);

            return $companyUserResponseTransfer;
        }

        $companyUserResponseTransfer->setIsSuccessful(false)
            ->addMessage((new ResponseMessageTransfer())->setText(static::MESSAGE_COMPANY_USER_NOT_FOUND));

        return $companyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function executeHydrationPlugins(CompanyUserTransfer $companyUserTransfer): CompanyUserTransfer
    {
        foreach ($this->companyUserHydrationPlugins as $companyUserHydrationPlugin) {
            $companyUserTransfer = $companyUserHydrationPlugin->hydrate($companyUserTransfer);
        }

        return $companyUserTransfer;
    }
}
