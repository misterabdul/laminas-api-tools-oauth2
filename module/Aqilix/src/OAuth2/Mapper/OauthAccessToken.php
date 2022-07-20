<?php

namespace Aqilix\OAuth2\Mapper;

use Aqilix\ORM\Mapper\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * OauthAccessToken Mapper
 */
class OauthAccessToken extends Mapper
{
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository()
    {
        return $this->em->getRepository(\Aqilix\OAuth2\Entity\OauthAccessToken::class);
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
