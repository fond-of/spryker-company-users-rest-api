<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor;


use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class CompanyUserPluginExecutor implements CompanyUserPluginExecutorInterface
{
    /**
     * @var array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface>
     */
    protected $companyUserPostCreatePlugins;

    /**
     * @param array<\FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface> $companyUserPostCreatePlugins
     */
    public function __construct(array $companyUserPostCreatePlugins)
    {
        $this->companyUserPostCreatePlugins = $companyUserPostCreatePlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function executePostCreatePlugins(
        CompanyUserTransfer $companyUserTransfer,
        RestCompanyUsersRequestAttributesTransfer $companyUsersRequestAttributesTransfer
    ): CompanyUserTransfer {
        foreach ($this->companyUserPostCreatePlugins as $plugin) {
            $companyUserTransfer = $plugin->postCreate($companyUserTransfer, $companyUsersRequestAttributesTransfer);
        }

        return $companyUserTransfer;
    }
}
