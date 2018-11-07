<?php

namespace AppBundle\Resource\Filtering\Person;

use AppBundle\Resource\Filtering\AbstractFilterDefinition;
use AppBundle\Resource\Filtering\FilterDefinitionInterface;
use AppBundle\Resource\Filtering\SortableFilterDefinitionInterface;

class PersonFilterDefinition
    extends AbstractFilterDefinition
    implements FilterDefinitionInterface, SortableFilterDefinitionInterface
{
    /**
     * @var null|string
     */
    private $firstName;
    /**
     * @var null|string
     */
    private $lastName;
    /**
     * @var null|string
     */
    private $birthFrom;
    /**
     * @var null|string
     */
    private $birthTo;
    /**
     * @var null|string
     */
    private $sortBy;
    /**
     * @var array|null
     */
    private $sortByArray;

    public function __construct(
        ?string $firstName,
        ?string $lastName,
        ?string $birthFrom,
        ?string $birthTo,
        ?string $sortByQuery,
        ?array $sortByArray
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthFrom = $birthFrom;
        $this->birthTo = $birthTo;
        $this->sortBy = $sortByQuery;
        $this->sortByArray = $sortByArray;
    }

    public function getParameters(): array
    {
        return get_object_vars($this);
    }

    public function getSortByQuery(): ?string
    {
        return $this->sortBy;
    }

    public function getSortByArray(): ?array
    {
        return $this->sortByArray;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return null|string
     */
    public function getBirthFrom(): ?string
    {
        return $this->birthFrom;
    }

    /**
     * @return null|string
     */
    public function getBirthTo(): ?string
    {
        return $this->birthTo;
    }
}