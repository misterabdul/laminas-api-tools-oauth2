<?php

namespace User\V1\Command;

use Laminas\ServiceManager\Factory\FactoryInterface;

class GenerateAdminUserFactory implements FactoryInterface
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
        $userMapper = $container->get(\Aqilix\OAuth2\Mapper\OauthUser::class);
        $logger = $container->get("logger_default");

        return new GenerateAdminUser(
            $userProfileMapper,
            $userMapper,
            $logger
        );
    }
}
