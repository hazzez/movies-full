<?php

namespace AppBundle\Resource\Filtering;

interface SortableFilterDefinitionInterface
{
    public function getSortByQuery(): ?string;
    public function getSortByArray(): ?array;
}