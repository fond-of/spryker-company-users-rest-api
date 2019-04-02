<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Zed\SequenceNumber\Business\SequenceNumberFacadeInterface;

class CompanyUsersRestApiToSequenceNumberFacadeBridge implements CompanyUsersRestApiToSequenceNumberFacadeInterface
{
    /**
     * @var \Spryker\Zed\SequenceNumber\Business\SequenceNumberFacadeInterface
     */
    protected $sequenceNumberFacade;

    /**
     * @param \Spryker\Zed\SequenceNumber\Business\SequenceNumberFacadeInterface $sequenceNumberFacade
     */
    public function __construct(SequenceNumberFacadeInterface $sequenceNumberFacade)
    {
        $this->sequenceNumberFacade = $sequenceNumberFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\SequenceNumberSettingsTransfer $sequenceNumberSettings
     *
     * @return string
     */
    public function generate(SequenceNumberSettingsTransfer $sequenceNumberSettings): string
    {
        return $this->sequenceNumberFacade->generate($sequenceNumberSettings);
    }
}
