<?php

namespace AppBundle\Resource\Filtering\Role;

use AppBundle\Resource\Filtering\AbstractFilterDefinitionFactory;
use AppBundle\Resource\Filtering\FilterDefinitionFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class RoleFilterDefinitionFactory
    extends AbstractFilterDefinitionFactory
    implements FilterDefinitionFactoryInterface
{
    private const ACCEPTED_SORT_FIELDS = ['playedName', 'movie'];

    public function factory(Request $request, ?int $movie): RoleFilterDefinition
    {
        return new RoleFilterDefinition(
            $request->get('playedName'),
            $movie,
            $request->get('sortBy'),
            $this->sortQueryToArray($request->get('sortBy'))
        );
    }

    public function getAcceptedSortFields(): array
    {
        return self::ACCEPTED_SORT_FIELDS;
    }
}