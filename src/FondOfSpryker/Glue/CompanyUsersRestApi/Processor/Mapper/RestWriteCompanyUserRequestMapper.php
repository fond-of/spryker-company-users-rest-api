<?php

namespace FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Mapper;

use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface;
use FondOfSpryker\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestWriteCompanyUserRequestMapper implements RestWriteCompanyUserRequestMapperInterface
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
     * @return \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer
     */
    public function fromRestRequest(RestRequestInterface $restRequest): RestWriteCompanyUserRequestTransfer
    {
        return (new RestWriteCompanyUserRequestTransfer())
            ->setIdCustomer($this->idCustomerFilter->filterFromRestRequest($restRequest))
            ->setWriteableCompanyUserReference($this->companyUserReferenceFilter->filterFromRestRequest($restRequest));
    }
}
