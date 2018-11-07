<?php

namespace AppBundle\Resource\Filtering;

abstract class AbstractFilterDefinitionFactory
    implements FilterDefinitionFactoryInterface
{
    public function sortQueryToArray(?string $sortByQuery): ?array
    {
        if (null === $sortByQuery) {
            return null;
        }

        return array_intersect_key(array_reduce(
            explode(',', $sortByQuery),
            function ($carry, $item) {
                list($by, $order) = array_replace(
                    [1 => 'desc'],
                    explode(
                        ' ',
                        preg_replace('/\s+/', ' ', $item)
                    )
                );
                $carry[$by] = $order;

                return $carry;
            },
            []
        ), array_flip($this->getAcceptedSortFields()));
    }
}