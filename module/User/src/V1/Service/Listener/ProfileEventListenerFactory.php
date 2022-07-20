<?php

namespace User\V1\Service\Listener;

use Laminas\ServiceManager\Factory\FactoryInterface;

class ProfileEventListenerFactory implements FactoryInterface
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
        $userProfileMapper = $container->get(\User\Mapper\UserProfile::class);
        $userProfileHydrator = $container->get('HydratorManager')->get('User\\Hydrator\\UserProfile');
        $logger = $container->get("logger_default");

        return new ProfileEventListener(
            $config,
            $userProfileMapper,
            $userProfileHydrator,
            $logger
        );
    }
}
