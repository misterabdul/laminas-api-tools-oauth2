<?php

namespace Aqilix\OAuth2\Mapper;

use Aqilix\ORM\Mapper\Mapper;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * OauthClient Mapper
 */
class OauthClient extends Mapper
{
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository()
    {
        return $this->em->getRepository(\Aqilix\OAuth2\Entity\OauthClient::class);
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
