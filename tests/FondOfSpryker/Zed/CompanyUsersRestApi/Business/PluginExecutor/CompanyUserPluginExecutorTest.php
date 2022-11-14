<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface;
use FondOfOryx\Zed\CompanyUsersRestApiExtension\Dependency\Plugin\CompanyUserPreCreatePluginInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;

class CompanyUserPluginExecutorTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUsersRequestAttributesTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface
     */
    protected $pluginExecutor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserPreCreatePluginMock = $this->getMockBuilder(CompanyUserPreCreatePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserPostCreatePluginMock = $this->getMockBuilder(CompanyUserPostCreatePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pluginExecutor = new CompanyUserPluginExecutor(
            [$this->companyUserPreCreatePluginMock],
            [$this->companyUserPostCreatePluginMock],
        );
    }

    /**
     * @return void
     */
    public function testExecutePostCreatePlugins(): void
    {
        $this->companyUserPostCreatePluginMock->expects(static::atLeastOnce())
            ->method('postCreate')
            ->with($this->companyUserTransferMock, $this->companyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        static::assertInstanceOf(
            CompanyUserTransfer::class,
            $this->pluginExecutor->executePostCreatePlugins(
                $this->companyUserTransferMock,
                $this->companyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExecutePreCreatePlugins(): void
    {
        $this->companyUserPreCreatePluginMock->expects(static::atLeastOnce())
            ->method('preCreate')
            ->with($this->companyUserTransferMock, $this->companyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        static::assertInstanceOf(
            CompanyUserTransfer::class,
            $this->pluginExecutor->executePreCreatePlugins(
                $this->companyUserTransferMock,
                $this->companyUsersRequestAttributesTransferMock,
            ),
        );
    }
}
