<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper;

use FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestAddressTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CompanyUserUnitAddressQuoteMapper implements CompanyUserUnitAddressQuoteMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade
     */
    public function __construct(CompanyUsersRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade)
    {
        $this->companyUserReferenceFacade = $companyUserReferenceFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function mapCompanyUserUnitAddressesToQuote(
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        $companyUserTransfer = (new CompanyUserTransfer())
            ->setCompanyUserReference($quoteTransfer->getCompanyUserReference());

        $companyUserResponseTransfer = $this->companyUserReferenceFacade
            ->findCompanyUserByCompanyUserReference($companyUserTransfer);

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $quoteTransfer;
        }

        if ($restCheckoutRequestAttributesTransfer->getBillingAddress() !== null) {
            $billingAddress = $this->getAddressTransfer(
                $restCheckoutRequestAttributesTransfer->getBillingAddress(),
                $companyUserResponseTransfer->getCompanyUser()
            );
            $quoteTransfer->setBillingAddress($billingAddress);
        }

        if ($restCheckoutRequestAttributesTransfer->getShippingAddress() !== null) {
            $shippingAddress = $this->getAddressTransfer(
                $restCheckoutRequestAttributesTransfer->getShippingAddress(),
                $companyUserResponseTransfer->getCompanyUser()
            );
            $quoteTransfer->setShippingAddress($shippingAddress);
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestAddressTransfer $restAddressTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    protected function getAddressTransfer(
        RestAddressTransfer $restAddressTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): AddressTransfer {
        $addressTransfer = (new AddressTransfer())
            ->fromArray($restAddressTransfer->toArray(), true);

        if ($restAddressTransfer->getId() === null || $companyUserTransfer->getCompanyBusinessUnit() === null) {
            return $addressTransfer;
        }

        $companyUnitAddressCollectionTransfer = $companyUserTransfer->getCompanyBusinessUnit()->getAddressCollection();

        if ($companyUnitAddressCollectionTransfer === null) {
            return $addressTransfer;
        }

        foreach ($companyUnitAddressCollectionTransfer->getCompanyUnitAddresses() as $companyUnitAddressTransfer) {
            if ($companyUnitAddressTransfer->getUuid() !== $restAddressTransfer->getId()) {
                continue;
            }

            $addressTransfer = (new AddressTransfer())
                ->fromArray($companyUnitAddressTransfer->toArray(), true)
                ->setIdCompanyUnitAddress($companyUnitAddressTransfer->getIdCompanyUnitAddress());

            $companyName = $this->getCompanyNameByCompanyUserTransfer($companyUserTransfer);

            if ($companyName !== null) {
                $addressTransfer->setFirstName($companyName)
                    ->setLastName('');
            }

            break;
        }

        return $addressTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return string|null
     */
    protected function getCompanyNameByCompanyUserTransfer(CompanyUserTransfer $companyUserTransfer): ?string
    {
        $companyTransfer = $companyUserTransfer->getCompany();

        if ($companyTransfer !== null && $companyTransfer->getName() !== null) {
            return $companyTransfer->getName();
        }

        $companyBusinessUnitTransfer = $companyUserTransfer->getCompanyBusinessUnit();

        if ($companyBusinessUnitTransfer === null || $companyBusinessUnitTransfer->getCompany() === null) {
            return null;
        }

        return $companyBusinessUnitTransfer->getCompany()->getName();
    }
}
