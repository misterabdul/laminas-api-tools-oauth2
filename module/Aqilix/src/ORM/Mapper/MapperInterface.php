<?php

namespace Aqilix\ORM\Mapper;

/**
 * Interface of Entity
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
interface MapperInterface
{
    /**
     * @param  \Doctrine\ORM\EntityManagerInterface  $em
     * @return self
     */
    public function setEntityManager($em);

    /**
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    public function getEntityManager();

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository();

    /**
     * @param  string  $id
     * @return object|null
     */
    public function fetchOne($id);

    /**
     * @param  array  $params
     * @return object|null
     */
    public function fetchOneBy($params);

    /**
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     */
    public function fetchAll($params);

    /**
     * @param  \Aqilix\ORM\Entity\EntityInterface  $entity
     * @return void
     */
    public function save($entity);

    /**
     * @param  \Aqilix\ORM\Entity\EntityInterface  $entity
     * @return void
     */
    public function delete($entity);
}
