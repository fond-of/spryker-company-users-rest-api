<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\SpyCompanyUserEntityTransfer;

interface CompanyUserMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\SpyCompanyUserEntityTransfer $companyUserEntityTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapEntityTransferToCompanyUserTransfer(
        SpyCompanyUserEntityTransfer $companyUserEntityTransfer
    ): CompanyUserTransfer;

    /**
     * @param \Generated\Shared\Transfer\SpyCompanyUserEntityTransfer[] $collection
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function mapCompanyUserCollection($collection): CompanyUserCollectionTransfer;
}
