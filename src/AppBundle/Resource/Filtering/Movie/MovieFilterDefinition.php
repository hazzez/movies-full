<?php

namespace AppBundle\Resource\Filtering\Movie;

use AppBundle\Resource\Filtering\AbstractFilterDefinition;
use AppBundle\Resource\Filtering\FilterDefinitionInterface;
use AppBundle\Resource\Filtering\SortableFilterDefinitionInterface;

class MovieFilterDefinition
    extends AbstractFilterDefinition
    implements FilterDefinitionInterface, SortableFilterDefinitionInterface
{
    /**
     * @var null|string
     */
    private $title;
    /**
     * @var int|null
     */
    private $yearFrom;
    /**
     * @var int|null
     */
    private $yearTo;
    /**
     * @var int|null
     */
    private $timeFrom;
    /**
     * @var int|null
     */
    private $timeTo;
    /**
     * @var null|string
     */
    private $sortBy;
    /**
     * @var array|null
     */
    private $sortByArray;

    public function __construct(
        ?string $title,
        ?int $yearFrom,
        ?int $yearTo,
        ?int $timeFrom,
        ?int $timeTo,
        ?string $sortByQuery,
        ?array $sortByArray
    )
    {
        $this->title = $title;
        $this->yearFrom = $yearFrom;
        $this->yearTo = $yearTo;
        $this->timeFrom = $timeFrom;
        $this->timeTo = $timeTo;
        $this->sortBy = $sortByQuery;
        $this->sortByArray = $sortByArray;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getYearFrom(): ?int
    {
        return $this->yearFrom;
    }

    /**
     * @return int|null
     */
    public function getYearTo(): ?int
    {
        return $this->yearTo;
    }

    /**
     * @return int|null
     */
    public function getTimeFrom(): ?int
    {
        return $this->timeFrom;
    }

    /**
     * @return int|null
     */
    public function getTimeTo(): ?int
    {
        return $this->timeTo;
    }

    /**
     * @return null|string
     */
    public function getSortByQuery(): ?string
    {
        return $this->sortBy;
    }

    /**
     * @return array|null
     */
    public function getSortByArray(): ?array
    {
        return $this->sortByArray;
    }

    public function getParameters(): array
    {
        return get_object_vars($this);
    }
}