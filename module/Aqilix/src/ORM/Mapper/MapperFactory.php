<?php

namespace Aqilix\ORM\Mapper;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

/**
 * Mapper Factory
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
abstract class MapperFactory implements AbstractFactoryInterface
{
    /**
     * @var array
     */
    protected $mappers = [];

    /**
     * @var string
     */
    protected $mapperPrefix = 'Aqilix\\ORM\\Mapper\\';

    /**
     * @param  \Psr\Container\ContainerInterface  $container
     * @param  string  $requestedName
     * @param  array|null  $options
     * @return object
     * @throws \Laminas\ServiceManager\Exception\ServiceNotFoundException If unable to resolve the service.
     * @throws \Laminas\ServiceManager\Exception\ServiceNotCreatedException If an exception is raised when creating a service.
     * @throws \Psr\Container\ContainerExceptionInterface If any other error occurs.
     */
    public function __invoke($container, $requestedName, $options = null)
    {
        if (isset($this->mappers[$requestedName])) {
            return $this->mappers[$requestedName];
        }

        $className = '\\' . ucfirst($requestedName);
        $mapper = new $className;
        if (!($mapper instanceof Mapper))
            throw new ServiceNotCreatedException('Mapper class must extends the \\Aqilix\\ORM\\Mapper\\AbstractMapper class.');

        $mapper->setEntityManager($container->get(\Doctrine\ORM\EntityManager::class));
        $this->mappers[$requestedName] = $mapper;
        return $mapper;
    }

    /**
     * @param  \Psr\Container\ContainerInterface  $container
     * @param  string  $requestedName
     * @return bool
     */
    public function canCreate($container, $requestedName)
    {
        if (strpos($requestedName, $this->mapperPrefix) !== false) {
            return true;
        }

        return false;
    }
}
