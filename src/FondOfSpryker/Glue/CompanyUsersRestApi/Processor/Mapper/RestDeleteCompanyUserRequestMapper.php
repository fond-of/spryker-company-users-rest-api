<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper;

use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestDeleteCompanyUserRequestMapper implements RestDeleteCompanyUserRequestMapperInterface
{
    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface
     */
    protected $idCustomerFilter;

    /**
     * @var \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface
     */
    protected $companyUserReferenceFilter;

    /**
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface $idCustomerFilter
     * @param \FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface $companyUserReferenceFilter
     */
    public function __construct(IdCustomerFilterInterface $idCustomerFilter, CompanyUserReferenceFilterInterface $companyUserReferenceFilter)
    {
        $this->idCustomerFilter = $idCustomerFilter;
        $this->companyUserReferenceFilter = $companyUserReferenceFilter;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer
     */
    public function fromRestRequest(RestRequestInterface $restRequest): RestDeleteCompanyUserRequestTransfer
    {
        return (new RestDeleteCompanyUserRequestTransfer())
            ->setIdCustomer($this->idCustomerFilter->filterFromRestRequest($restRequest))
            ->setCompanyUserReferenceToDelete($this->companyUserReferenceFilter->filterFromRestRequest($restRequest));
    }
}
