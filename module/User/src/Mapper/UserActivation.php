<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserActivation Mapper
 */
class UserActivation extends Mapper
{
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository()
    {
        return $this->em->getRepository(\User\Entity\UserActivation::class);
    }

    /**
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     */
    public function fetchAll($params)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('t');

        $query = $qb->getQuery();

        return $query;
    }
}
