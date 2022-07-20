<?php

namespace Aqilix\ORM\Mapper;

use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;

/**
 * Mapper with Doctrine support
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
abstract class Mapper implements MapperInterface
{
    /**
     * EntityManager Object
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Set EntityManager
     *
     * @param  \Doctrine\ORM\EntityManagerInterface  $em
     * @return self
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
        return $this;
    }

    /**
     * Get EntityManager
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     **/
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    abstract public function getEntityRepository();

    /**
     * Save Entity
     *
     * @param  \Aqilix\ORM\Entity\EntityInterface $entity
     * @return void
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * Fetch Review by Id
     *
     * @param  int  $id
     * @return object|null
     */
    public function fetchOne($id)
    {
        return $this->getEntityRepository()->findOneBy(['uuid' => $id]);
    }

    /**
     * Fetch single records with params
     *
     * @param  array  $params
     * @return object|null
     */
    public function fetchOneBy($params = [])
    {
        return $this->getEntityRepository()->findOneBy($params);
    }

    /**
     * Fetch Reviews with pagination
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     */
    abstract public function fetchAll($params);

    /**
     * Get Paginator Adapter for list
     *
     * @param  array  $params
     * @return \DoctrineORMModule\Paginator\Adapter\DoctrinePaginator
     */
    public function buildListPaginatorAdapter($params)
    {
        $query = $this->fetchAll($params);
        $doctrinePaginator = new DoctrinePaginator($query, true);
        $adapter = new DoctrinePaginatorAdapter($doctrinePaginator);

        return $adapter;
    }

    /**
     * Delete Entity
     *
     * @param  \Aqilix\ORM\Entity\EntityInterface  $entity
     * @return void
     */
    public function delete($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
