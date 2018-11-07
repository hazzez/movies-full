<?php

namespace AppBundle\Resource\Pagination\Role;

use AppBundle\Resource\Filtering\ResourceFilterInterface;
use AppBundle\Resource\Filtering\Role\RoleResourceFilter;
use AppBundle\Resource\Pagination\AbstractPagination;
use AppBundle\Resource\Pagination\PaginationInterface;

class RolePagination
    extends AbstractPagination
    implements PaginationInterface
{
    private const ROUTE = 'get_movie_roles';

    /**
     * @var RoleResourceFilter
     */
    private $resourceFilter;

    public function __construct(RoleResourceFilter $resourceFilter)
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