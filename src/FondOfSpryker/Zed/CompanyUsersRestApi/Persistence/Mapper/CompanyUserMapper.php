<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\SpyCompanyUserEntityTransfer;

class CompanyUserMapper implements CompanyUserMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\SpyCompanyUserEntityTransfer $companyUserEntityTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapEntityTransferToCompanyUserTransfer(
        SpyCompanyUserEntityTransfer $companyUserEntityTransfer
    ): CompanyUserTransfer {
        $companyUserTransfer = (new CompanyUserTransfer())->fromArray($companyUserEntityTransfer->modifiedToArray(), true);

        if ($companyUserEntityTransfer->getCustomer()) {
            $customerTransfer = (new CustomerTransfer())->fromArray(
                $companyUserEntityTransfer->getCustomer()->modifiedToArray(),
                true
            );
            $companyUserTransfer->setCustomer($customerTransfer);
        }

        if ($companyUserEntityTransfer->getCompany()) {
            $companyTransfer = (new CompanyTransfer())->fromArray(
                $companyUserEntityTransfer->getCompany()->modifiedToArray(),
                true
            );
            $companyUserTransfer->setCompany($companyTransfer);
        }

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SpyCompanyUserEntityTransfer[] $collection
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function mapCompanyUserCollection(array $collection): CompanyUserCollectionTransfer
    {
        $companyUsers = new ArrayObject();
        $companyUserCollectionTransfer = new CompanyUserCollectionTransfer();

        foreach ($collection as $companyUserEntityTransfer) {
            $companyUsers->append($this->mapEntityTransferToCompanyUserTransfer($companyUserEntityTransfer));
        }

        $companyUserCollectionTransfer->setCompanyUsers($companyUsers);

        return $companyUserCollectionTransfer;
    }
}
