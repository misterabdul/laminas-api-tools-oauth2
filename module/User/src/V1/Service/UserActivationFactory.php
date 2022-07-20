<?php

namespace User\V1\Service;

use Laminas\ServiceManager\Factory\FactoryInterface;

class UserActivationFactory implements FactoryInterface
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

        return new UserActivation(
            $userProfileMapper,
            $userActivationMapper
        );
    }
}
