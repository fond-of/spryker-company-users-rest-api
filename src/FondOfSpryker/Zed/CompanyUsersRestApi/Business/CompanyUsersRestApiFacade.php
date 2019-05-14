<?php

namespace FondOfSpryker\Zed\CompanyUsersRestApi\Business;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiBusinessFactory getFactory()
 * @method \FondOfSpryker\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface getRepository()
 */
class CompanyUsersRestApiFacade extends AbstractFacade implements CompanyUsersRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function create(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        return $this->getFactory()->createCompanyUserWriter()->create($restCompanyUsersRequestAttributesTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function update(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        return $this->getFactory()->createCompanyUserWriter()->update($restCompanyUsersRequestAttributesTransfer);
    }

    /**
     * Specification:
     * - Map to company user transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapToCompanyUser(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        return $this->getFactory()->createCompanyUserMapper()->mapCompanyUser(
            $restCompanyUsersRequestAttributesTransfer,
            $companyUserTransfer
        );
    }

    /**
     * Specification:
     * - Map customer to company user transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapCustomerToCompanyUser(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        return $this->getFactory()->createCustomerCompanyUserMapper()->mapCustomerToCompanyUser(
            $restCompanyUsersRequestAttributesTransfer,
            $companyUserTransfer
        );
    }

    /**
     * Specification:
     * - Map company to company user transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapCompanyToCompanyUser(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        return $this->getFactory()->createCompanyCompanyUserMapper()->mapCompanyToCompanyUser(
            $restCompanyUsersRequestAttributesTransfer,
            $companyUserTransfer
        );
    }

    /**
     * Specification:
     * - Map company business unit to company user transfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapCompanyBusinessUnitToCompanyUser(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        return $this->getFactory()->createCompanyBusinessUnitCompanyUserMapper()->mapCompanyBusinessUnitToCompanyUser(
            $restCompanyUsersRequestAttributesTransfer,
            $companyUserTransfer
        );
    }

    /**
     * Specification:
     * - Generate company user reference.
     *
     * @api
     *
     * @return string
     */
    public function generateCompanyUserReference(): string
    {
        return $this->getFactory()->createCompanyUserReferenceGenerator()->generateCompanyUserReference();
    }

    /**
     * Specification:
     * - Retrieves company user information by external reference.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function findCompanyUserByExternalReference(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        return $this->getFactory()->createCompanyUserReader()
            ->findCompanyUserByExternalReference($restCompanyUsersRequestAttributesTransfer);
    }

    /**
     * Specification:
     * - Retrieves company user information by external reference.
     *
     * @api
     *
     * @param string $externalReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findByExternalReference(string $externalReference): ?CompanyUserTransfer
    {
        return $this->getRepository()->findCompanyUserByExternalReference($externalReference);
    }

    /**
     * Specification:
     * - Retrieves company user information by company user reference.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer
    {
        return $this->getFactory()->createCompanyUserReader()
            ->findCompanyUserByCompanyUserReference($companyUserTransfer);
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
        return $this->getFactory()
            ->createCompanyUserUnitAddressQuoteMapper()
            ->mapCompanyUserUnitAddressesToQuote($restCheckoutRequestAttributesTransfer, $quoteTransfer);
    }
}
