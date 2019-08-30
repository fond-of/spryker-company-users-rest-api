<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business\Addresses\Mapper;

use FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestAddressTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CompanyUserUnitAddressQuoteMapper implements CompanyUserUnitAddressQuoteMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface
     */
    protected $companyUsersRestApiFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacadeInterface $companyUsersRestApiFacade
     */
    public function __construct(CompanyUsersRestApiFacadeInterface $companyUsersRestApiFacade)
    {
        $this->companyUsersRestApiFacade = $companyUsersRestApiFacade;
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

        $companyUserTransfer = new CompanyUserTransfer();
        $companyUserTransfer->setCompanyUserReference($quoteTransfer->getCompanyUserReference());
        $companyUserResponseTransfer = $this->companyUsersRestApiFacade->findCompanyUserByCompanyUserReference($companyUserTransfer);
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
    protected function getAddressTransfer(RestAddressTransfer $restAddressTransfer, CompanyUserTransfer $companyUserTransfer): AddressTransfer
    {
        if ($restAddressTransfer->getId() && $companyUserTransfer->getCompanyBusinessUnit()) {

            $companyUnitAddressCollectionTransfer = $companyUserTransfer->getCompanyBusinessUnit()->getAddressCollection();

            if ($companyUnitAddressCollectionTransfer) {
                foreach ($companyUnitAddressCollectionTransfer->getCompanyUnitAddresses() as $companyUnitAddressTransfer) {
                    if ($companyUnitAddressTransfer->getUuid() === $restAddressTransfer->getId()) {
                        $addressTransfer = (new AddressTransfer())->fromArray($companyUnitAddressTransfer->toArray(), true);
                        $addressTransfer->setFirstName($companyUserTransfer->getCompanyBusinessUnit()->getName());
                        $addressTransfer->setLastName('');

                        return $addressTransfer;
                    }
                }
            }
        }

        return (new AddressTransfer())->fromArray($restAddressTransfer->toArray(), true);
    }
}
