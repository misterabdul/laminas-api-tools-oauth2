<?php

namespace User\Mapper;

use Aqilix\ORM\Mapper\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * UserProfile Mapper
 */
class UserProfile extends Mapper
{
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository()
    {
        return $this->em->getRepository(\User\Entity\UserProfile::class);
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

    /**
     * @param  string  $username
     * @return \User\Entity\UserProfile|null
     */
    public function fetchOneByOauthUsername($username)
    {
        try {
            $qb = $this->getEntityRepository()->createQueryBuilder('t');
            $qb->innerJoin('t.user', 'u');

            $qb->where('u.username = :username')
                ->setParameter('username', $username);

            $qb->setMaxResults(1);
            $query = $qb->getQuery();

            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $ex) {
            return null;
        }
    }
}
