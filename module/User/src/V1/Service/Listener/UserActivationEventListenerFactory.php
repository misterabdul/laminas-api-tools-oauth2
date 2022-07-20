<?php

namespace User\V1\Service\Listener;

use Laminas\ServiceManager\Factory\FactoryInterface;

class UserActivationEventListenerFactory implements FactoryInterface
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
        $userProfileMapper = $container->get(\User\Mapper\UserProfile::class);
        $userActivationMapper = $container->get(\User\Mapper\UserActivation::class);
        $logger = $container->get("logger_default");

        return new UserActivationEventListener(
            $userProfileMapper,
            $userActivationMapper,
            $logger
        );
    }
}
