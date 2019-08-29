<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi;

use FondOfSpryker\Shared\CompanyUsersRestApi\CompanyUsersRestApiConstants;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\SequenceNumber\SequenceNumberConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CompanyUsersRestApiConfig extends AbstractBundleConfig
{
    /**
     * @return \Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    public function getCompanyUserReferenceDefaults(): SequenceNumberSettingsTransfer
    {
        $sequenceNumberSettingsTransfer = new SequenceNumberSettingsTransfer();

        $sequenceNumberSettingsTransfer->setName(CompanyUsersRestApiConstants::NAME_COMPANY_USER_REFERENCE);

        $sequenceNumberPrefixParts = [];
        $sequenceNumberPrefixParts[] = Store::getInstance()->getStoreName();
        $sequenceNumberPrefixParts[] = $this->get(SequenceNumberConstants::ENVIRONMENT_PREFIX);
        $sequenceNumberPrefixParts[] = CompanyUsersRestApiConstants::PREFIX_COMPANY_USER_REFERENCE;
        $prefix = implode($this->getUniqueIdentifierSeparator(), $sequenceNumberPrefixParts) . $this->getUniqueIdentifierSeparator();
        $sequenceNumberSettingsTransfer->setPrefix($prefix);

        return $sequenceNumberSettingsTransfer;
    }

    /**
     * @return string
     */
    protected function getUniqueIdentifierSeparator(): string
    {
        return '-';
    }
}
