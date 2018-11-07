<?php

namespace AppBundle\Resource\Pagination\Person;

use AppBundle\Resource\Filtering\Person\PersonResourceFilter;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use AppBundle\Resource\Pagination\AbstractPagination;
use AppBundle\Resource\Pagination\PaginationInterface;

class PersonPagination
    extends AbstractPagination
    implements PaginationInterface
{
    private const ROUTE = 'get_humans';

    /**
     * @var PersonResourceFilter
     */
    private $resourceFilter;

    public function __construct(PersonResourceFilter $resourceFilter)
    {
        $this->resourceFilter = $resourceFilter;
    }

    public function getResourceFilter(): ResourceFilterInterface
    {
        return $this->resourceFilter;
    }

    public function getRouteName(): string
    {
        return self::ROUTE;
    }
}