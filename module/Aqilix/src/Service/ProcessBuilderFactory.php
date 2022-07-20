<?php

namespace Aqilix\Service;

use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * PhpProcess Builder Factory
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class ProcessBuilderFactory implements FactoryInterface
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
        $config = $container->get('Config')['project']['php_process'];
        $process = new ProcessBuilder([$config['php_binary'], $config['script']]);

        return $process;
    }
}
