<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Controller;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUserDisablerInterface;
use Generated\Shared\Transfer\RestDisableCompanyUserRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class DisableCompanyUserResourceControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory
     */
    protected $companyUsersRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUserDisablerInterface
     */
    protected $companyUserDisablerMock;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Controller\DisableCompanyUserResourceController
     */
    protected $disableCompanyUserResourceController;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restDisableCompanyUserRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserDisablerMock = $this->getMockBuilder(CompanyUserDisablerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiFactoryMock = $this->getMockBuilder(CompanyUsersRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDisableCompanyUserRequestAttributesTransferMock = $this->getMockBuilder(RestDisableCompanyUserRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->disableCompanyUserResourceController = new class ($this->companyUsersRestApiFactoryMock) extends DisableCompanyUserResourceController
        {
            /**
             * @var \FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory
             */
            protected $companyUsersRestApiFactoryMock;

            /**
             *  constructor.
             *
             * @param \FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory $companyUsersRestApiFactoryMock
             */
            public function __construct(CompanyUsersRestApiFactory $companyUsersRestApiFactoryMock)
            {
                $this->companyUsersRestApiFactoryMock = $companyUsersRestApiFactoryMock;
            }

            /**
             * @return \FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory
             */
            public function getFactory(): CompanyUsersRestApiFactory
            {
                return $this->companyUsersRestApiFactoryMock;
            }
        };
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->companyUsersRestApiFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyUsersDisabler')
            ->willReturn($this->companyUserDisablerMock);

        $this->companyUserDisablerMock->expects($this->atLeastOnce())
            ->method('disableCompanyUser')
            ->with($this->restRequestMock, $this->restDisableCompanyUserRequestAttributesTransferMock)
            ->willReturn($this->restResponseMock);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->disableCompanyUserResourceController->postAction(
                $this->restRequestMock,
                $this->restDisableCompanyUserRequestAttributesTransferMock,
            ),
        );
    }
}
