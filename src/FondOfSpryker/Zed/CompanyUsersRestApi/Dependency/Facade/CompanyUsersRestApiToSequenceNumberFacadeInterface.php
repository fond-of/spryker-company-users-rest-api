<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;

interface CompanyUsersRestApiToSequenceNumberFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\SequenceNumberSettingsTransfer $sequenceNumberSettings
     *
     * @return string
     */
    public function generate(SequenceNumberSettingsTransfer $sequenceNumberSettings): string;
}
