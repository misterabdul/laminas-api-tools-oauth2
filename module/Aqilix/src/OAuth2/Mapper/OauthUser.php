<?php

namespace Aqilix\OAuth2\Mapper;

use Aqilix\ORM\Mapper\Mapper;
use Laminas\Crypt\Password\Bcrypt;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * OauthUser Mapper
 */
class OauthUser extends Mapper
{
    /**
     * @var \Laminas\Crypt\Password\PasswordInterface
     */
    protected $hashMethod;

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository()
    {
        return $this->em->getRepository(\Aqilix\OAuth2\Entity\OauthUser::class);
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
     * @return \Laminas\Crypt\Password\PasswordInterface
     */
    public function getHashMethod()
    {
        if ($this->hashMethod == null) {
            $this->hashMethod = new Bcrypt();
            $this->hashMethod->setCost(10);
        }

        return $this->hashMethod;
    }

    /**
     * Set hash method
     *
     * @param  \Laminas\Crypt\Password\PasswordInterface  $hashMethod
     * @return self
     */
    public function setHashMethod($hashMethod)
    {
        $this->hashMethod = $hashMethod;

        return $this;
    }

    /**
     * Create Hash Password
     *
     * @param  string  $password
     * @return string
     */
    public function getPasswordHash($password)
    {
        return $this->getHashMethod()->create($password);
    }

    /**
     * Verify password and hash password
     *
     * @param string $password
     * @param string $passwordHash
     *
     * @return boolean
     */
    public function verifyPassword($password, $passwordHash)
    {
        return $this->getHashMethod()->verify($password, $passwordHash);
    }
}
