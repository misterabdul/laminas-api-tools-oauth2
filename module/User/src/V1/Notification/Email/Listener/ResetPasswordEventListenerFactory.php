<?php

namespace User\V1\Notification\Email\Listener;

use Laminas\ServiceManager\Factory\FactoryInterface;

class ResetPasswordEventListenerFactory implements FactoryInterface
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
        $processBuilder = $container->get(\Aqilix\Service\ProcessBuilder::class);
        $logger = $container->get("logger_default");

        return new ResetPasswordEventListener(
            $processBuilder,
            $logger
        );
    }
}
