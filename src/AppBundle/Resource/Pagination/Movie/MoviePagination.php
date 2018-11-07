<?php

namespace AppBundle\Resource\Pagination\Movie;

use AppBundle\Resource\Filtering\Movie\MovieResourceFilter;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use AppBundle\Resource\Pagination\AbstractPagination;
use AppBundle\Resource\Pagination\PaginationInterface;

class MoviePagination
    extends AbstractPagination
    implements PaginationInterface
{
    private const ROUTE = 'get_movies';
    /**
     * @var MovieResourceFilter
     */
    private $resourceFilter;

    public function __construct(MovieResourceFilter $resourceFilter)
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