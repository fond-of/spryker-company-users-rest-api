<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Writer;

use DateTimeImmutable;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CustomerWriter implements CustomerWriterInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface
     */
    protected $customerMapper;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface
     */
    protected $randomPasswordGenerator;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface
     */
    protected $restorePasswordKeyGenerator;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface
     */
    protected $restorePasswordLinkGenerator;

    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface $customerMapper
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface $randomPasswordGenerator
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface $restorePasswordKeyGenerator
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface $restorePasswordLinkGenerator
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
     */
    public function __construct(
        CustomerMapperInterface $customerMapper,
        RandomPasswordGeneratorInterface $randomPasswordGenerator,
        RestorePasswordKeyGeneratorInterface $restorePasswordKeyGenerator,
        RestorePasswordLinkGeneratorInterface $restorePasswordLinkGenerator,
        CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
    ) {
        $this->customerFacade = $customerFacade;
        $this->randomPasswordGenerator = $randomPasswordGenerator;
        $this->restorePasswordKeyGenerator = $restorePasswordKeyGenerator;
        $this->restorePasswordLinkGenerator = $restorePasswordLinkGenerator;
        $this->customerMapper = $customerMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function createByRestCustomer(RestCustomerTransfer $restCustomerTransfer): ?CustomerTransfer
    {
        $customerTransfer = $this->customerMapper->fromRestCustomer($restCustomerTransfer);

        $restorePasswordKey = $this->restorePasswordKeyGenerator->generate();

        $customerTransfer->setPassword($this->randomPasswordGenerator->generate())
            ->setRestorePasswordKey($restorePasswordKey)
            ->setRestorePasswordDate(new DateTimeImmutable())
            ->setRestorePasswordLink($this->restorePasswordLinkGenerator->generate($restorePasswordKey));

        $customerResponseTransfer = $this->customerFacade->addCustomer($customerTransfer);
        $customerTransfer = $customerResponseTransfer->getCustomerTransfer();

        if ($customerTransfer === null || $customerResponseTransfer->getIsSuccess() === false) {
            return null;
        }

        return $customerTransfer;
    }
}
