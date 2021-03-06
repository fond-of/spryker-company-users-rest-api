<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface
     */
    protected $repository;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface $repository
     */
    public function __construct(
        CompanyUsersRestApiRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    public function doesCompanyUserAlreadyExist(CompanyUserTransfer $companyUserTransfer): bool
    {
        if ($companyUserTransfer->getFkCustomer() === null ||
            $companyUserTransfer->getFkCompany() === null ||
            $companyUserTransfer->getFkCompanyBusinessUnit() === null) {
            return false;
        }

        $companyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())
            ->setIdCustomer($companyUserTransfer->getFkCustomer())
            ->setIdCompany($companyUserTransfer->getFkCompany())
            ->setIdCompanyBusinessUnit($companyUserTransfer->getFkCompanyBusinessUnit());

        $companyUserCollection = $this->repository
            ->findCompanyUsersByFilter($companyUserCriteriaFilterTransfer);

        return $companyUserCollection->getCompanyUsers()->count() > 0;
    }
}
