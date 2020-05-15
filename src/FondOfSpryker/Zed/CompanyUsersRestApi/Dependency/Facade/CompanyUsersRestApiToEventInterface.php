<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade;

use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface CompanyUsersRestApiToEventInterface
{
    /**
     * @param string $eventName
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     *
     * @return void
     */
    public function trigger($eventName, TransferInterface $transfer): void;
}
