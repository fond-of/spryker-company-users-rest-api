<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\Mail;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;

class CompanyUserInviteMailTypePluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Communication\Plugin\Mail\CompanyUserInviteMailTypePlugin
     */
    protected $companyUserInviteMailTypePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface
     */
    protected $mailBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MailTransfer
     */
    protected $mailTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->mailBuilderInterfaceMock = $this->getMockBuilder(MailBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailTransferMock = $this->getMockBuilder(MailTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->email = 'daniel.kemna@fondof.de';

        $this->firstName = 'first-name';

        $this->lastName = 'last-name';

        $this->companyUserInviteMailTypePlugin = new CompanyUserInviteMailTypePlugin();
    }

    /**
     * @return void
     */
    public function testGetName(): void
    {
        $this->assertSame(
            CompanyUserInviteMailTypePlugin::MAIL_TYPE,
            $this->companyUserInviteMailTypePlugin->getName()
        );
    }

    /**
     * @return void
     */
    public function testBuild(): void
    {
        $this->mailBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('getMailTransfer')
            ->willReturn($this->mailTransferMock);

        $this->mailTransferMock->expects($this->atLeastOnce())
            ->method('requireCustomer')
            ->willReturn($this->mailTransferMock);

        $this->mailTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getEmail')
            ->willReturn($this->email);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getFirstName')
            ->willReturn($this->firstName);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getLastName')
            ->willReturn($this->lastName);

        $this->mailBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('addRecipient')
            ->willReturn($this->mailBuilderInterfaceMock);

        $this->companyUserInviteMailTypePlugin->build($this->mailBuilderInterfaceMock);
    }
}
