<?php

declare(strict_types=1);

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
        return $this->getFactory()
            ->createCompanyUserWriter()
            ->create($restCompanyUsersRequestAttributesTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function update(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        return $this->getFactory()
            ->createCompanyUserWriter()
            ->update($restCompanyUsersRequestAttributesTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function delete(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        return $this->getFactory()
            ->createCompanyUserDeleter()
            ->delete($companyUserTransfer);
    }

    /**
     * @return string
     */
    public function generateCompanyUserReference(): string
    {
        return $this->getFactory()
            ->createCompanyUserReferenceGenerator()
            ->generateCompanyUserReference();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer
    {
        return $this->getFactory()
            ->createCompanyUserReader()
            ->findCompanyUserByCompanyUserReference($companyUserTransfer);
    }

    /**
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
