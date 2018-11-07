<?php

namespace AppBundle\Resource\Filtering;

abstract class AbstractFilterDefinition implements FilterDefinitionInterface
{
    private const QUERY_PARAMS_BLACKLIST = ['sortByArray'];

    public function getQueryParameters(): array
    {
        return array_diff_key(
            $this->getParameters(),
            array_flip($this->getQueryParamsBlacklist())
        );
    }

    public function getQueryParamsBlacklist(): array
    {
        return self::QUERY_PARAMS_BLACKLIST;
    }
}