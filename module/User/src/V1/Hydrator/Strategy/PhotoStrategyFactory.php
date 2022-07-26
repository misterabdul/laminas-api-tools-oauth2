<?php

namespace User\V1\Hydrator\Strategy;

use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Hydrator Strategy for Photo
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class PhotoStrategyFactory implements FactoryInterface
{
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
        $config = $container->get('Config')['user']['photo'];
        return new PhotoStrategy($config);
    }
}
