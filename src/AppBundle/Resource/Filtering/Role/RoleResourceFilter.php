<?php

namespace AppBundle\Resource\Filtering\Role;

use AppBundle\Repository\RoleRepository;
use AppBundle\Resource\Filtering\ResourceFilterInterface;
use Doctrine\ORM\QueryBuilder;

class RoleResourceFilter
    implements ResourceFilterInterface
{
    /**
     * @var RoleRepository
     */
    private $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param RoleFilterDefinition $filter
     * @return QueryBuilder
     */
    public function getResources($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('role');

        return $qb;
    }

    /**
     * @param RoleFilterDefinition $filter
     * @return QueryBuilder
     */
    public function getResourceCount($filter): QueryBuilder
    {
        $qb = $this->getQuery($filter);
        $qb->select('count(role)');

        return $qb;
    }

    private function getQuery(RoleFilterDefinition $filter): QueryBuilder
    {
        $qb = $this->repository->createQueryBuilder('role');

        if (null !== $filter->getPlayedName()) {
            $qb->where(
                $qb->expr()->like('role.playedName', ':playedName')
            );
            $qb->setParameter('playedName', "%{$filter->getPlayedName()}%");
        }

        if (null !== $filter->getMovie()) {
            $qb->andWhere(
                $qb->expr()->eq('role.movie', ':movieId')
            );
            $qb->setParameter('movieId', $filter->getMovie());
        }

        if (null !== $filter->getSortByArray()) {
            foreach ($filter->getSortByArray() as $by => $order) {
                $expr = 'desc' == $order
                    ? $qb->expr()->desc("role.$by")
                    : $qb->expr()->asc("role.$by");
                $qb->addOrderBy($expr);
            }
        }

        return $qb;
    }
}