<?php

namespace AppBundle\Resource\Filtering\Movie;

use AppBundle\Resource\Filtering\AbstractFilterDefinitionFactory;
use AppBundle\Resource\Filtering\FilterDefinitionFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MovieFilterDefinitionFactory
    extends AbstractFilterDefinitionFactory
    implements FilterDefinitionFactoryInterface
{
    private const ACCEPTED_SORT_FIELDS = ['id', 'title', 'year', 'time'];

    public function factory(Request $request): MovieFilterDefinition
    {
        return new MovieFilterDefinition(
            $request->get('title'),
            $request->get('yearFrom'),
            $request->get('yearTo'),
            $request->get('timeFrom'),
            $request->get('timeTo'),
            $request->get('sortBy'),
            $this->sortQueryToArray($request->get('sortBy'))
        );
    }

    public function getAcceptedSortFields(): array
    {
        return self::ACCEPTED_SORT_FIELDS;
    }
}