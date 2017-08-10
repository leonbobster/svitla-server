<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class Repository extends EntityRepository
{
    /**
     * @param array $criteria
     *
     * @return int
     */
    public function countBy(array $criteria): int
    {
        $alias = 'e';
        $qb = $this->createQueryBuilder($alias);

        /** @var QueryBuilder $qb */
        $qb = $qb->select($qb->expr()->count($alias));

        foreach ($criteria as $key => $val) {
            $qb->andWhere("{$alias}.{$key} = :{$key}")
                ->setParameter($key, $val);
        }

        return (int)$qb->getQuery()
            ->getSingleScalarResult();
    }
}
