<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
{
    public function getCountForMovie(int $movieId): int
    {
        $qb = $this->createQueryBuilder('r');

        return $qb->select('count(r.id)')
            ->where('r.movie = :movieId')
            ->setParameter('movieId', $movieId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}