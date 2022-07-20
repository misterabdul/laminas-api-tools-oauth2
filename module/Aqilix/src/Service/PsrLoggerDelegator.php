<?php

namespace Aqilix\Service;

use Aqilix\Log\Processor\PsrPlaceholder;
use Laminas\Log\PsrLoggerAdapter;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * Psr Logger Delegator
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class PsrLoggerDelegator implements DelegatorFactoryInterface
{
    /**
     * @param  \Psr\Container\ContainerInterface  $container
     * @param  string  $name
     * @param  callable  $callback
     * @param  array|null  $options
     * @return object
     * @throws \Laminas\ServiceManager\Exception\ServiceNotFoundException If unable to resolve the service.
     * @throws \Laminas\ServiceManager\Exception\ServiceNotCreatedException If an exception is raised when creating a service.
     * @throws \Psr\Container\ContainerExceptionInterface If any other error occurs.
     */
    public function __invoke($container, $name, $callback, $options = null)
    {
        $zendLogLogger = $callback();
        $zendLogLogger->addProcessor(new PsrPlaceholder());
        $psrLogger = new PsrLoggerAdapter($zendLogLogger);
        return $psrLogger;
    }
}
