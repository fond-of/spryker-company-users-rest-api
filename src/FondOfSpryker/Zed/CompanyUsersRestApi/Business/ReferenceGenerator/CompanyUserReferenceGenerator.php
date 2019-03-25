<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\ReferenceGenerator;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToSequenceNumberFacadeInterface;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;

class CompanyUserReferenceGenerator implements CompanyUserReferenceGeneratorInterface
{
    /**
     * @var \Spryker\Zed\Customer\Dependency\Facade\CustomerToSequenceNumberInterface
     */
    protected $facadeSequenceNumber;

    /**
     * @var \Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    protected $sequenceNumberSettings;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToSequenceNumberFacadeInterface $sequenceNumberFacade
     * @param \Generated\Shared\Transfer\SequenceNumberSettingsTransfer $sequenceNumberSettings
     */
    public function __construct(
        CompanyUsersRestApiToSequenceNumberFacadeInterface $sequenceNumberFacade,
        SequenceNumberSettingsTransfer $sequenceNumberSettings
    ) {
        $this->facadeSequenceNumber = $sequenceNumberFacade;
        $this->sequenceNumberSettings = $sequenceNumberSettings;
    }

    /**
     * @return string
     */
    public function generateCompanyUserReference(): string
    {
        return $this->facadeSequenceNumber->generate($this->sequenceNumberSettings);
    }
}
