<?php

namespace AppBundle\Resource\Pagination;

use AppBundle\Resource\Filtering\FilterDefinitionInterface;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use Hateoas\Representation\PaginatedRepresentation;

interface PaginationInterface
{
    public function paginate(Page $page, FilterDefinitionInterface $filter)
    : PaginatedRepresentation;
    public function getResourceFilter(): ResourceFilterInterface;
    public function getRouteName(): string;
}