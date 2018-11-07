<?php

namespace AppBundle\Resource\Filtering\Person;

use AppBundle\Resource\Filtering\AbstractFilterDefinitionFactory;
use AppBundle\Resource\Filtering\FilterDefinitionFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class PersonFilterDefinitionFactory
    extends AbstractFilterDefinitionFactory
    implements FilterDefinitionFactoryInterface
{
    private const ACCEPTED_SORT_FIELDS = ['id', 'firstName', 'lastName', 'dateOfBirth'];

    public function factory(Request $request): PersonFilterDefinition
    {
        return new PersonFilterDefinition(
            $request->get('firstName'),
            $request->get('lastName'),
            $request->get('birthFrom'),
            $request->get('birthTo'),
            $request->get('sortBy'),
            $this->sortQueryToArray($request->get('sortBy'))
        );
    }

    public function getAcceptedSortFields(): array
    {
        return self::ACCEPTED_SORT_FIELDS;
    }
}