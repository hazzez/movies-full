<?php

namespace AppBundle\Resource\Filtering;

interface FilterDefinitionInterface
{
    public function getQueryParameters(): array;
    public function getQueryParamsBlacklist(): array;
    public function getParameters(): array;
}