<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClient;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\CompanyUsers\CompanyUsersReader;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Creator\CompanyUserCreator;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleter;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdater;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class CompanyUsersRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReferenceClientMock;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyClientInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyClientMock;

    /**
     * @var \FondOfSpryker\Client\CompanyUsersRestApi\CompanyUsersRestApiClient&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restResourceBuilderMock;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceClientMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserReferenceClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyClientMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(CompanyUsersRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new class ($this->restResourceBuilderMock) extends CompanyUsersRestApiFactory {
            /**
             * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            protected $restResourceBuilder;

            /**
             * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
             */
            public function __construct(RestResourceBuilderInterface $restResourceBuilder)
            {
                $this->restResourceBuilder = $restResourceBuilder;
            }

            /**
             * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            public function getResourceBuilder(): RestResourceBuilderInterface
            {
                return $this->restResourceBuilder;
            }
        };
        $this->factory->setContainer($this->containerMock);
        $this->factory->setClient($this->clientMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserCreator(): void
    {
        static::assertInstanceOf(
            CompanyUserCreator::class,
            $this->factory->createCompanyUserCreator(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserUpdater(): void
    {
        static::assertInstanceOf(
            CompanyUserUpdater::class,
            $this->factory->createCompanyUserUpdater(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserDeleter(): void
    {
        static::assertInstanceOf(
            CompanyUserDeleter::class,
            $this->factory->createCompanyUserDeleter(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUsersReader(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER_REFERENCE)
            ->willReturn($this->companyUserReferenceClientMock);

        static::assertInstanceOf(
            CompanyUsersReader::class,
            $this->factory->createCompanyUsersReader(),
        );
    }
}
