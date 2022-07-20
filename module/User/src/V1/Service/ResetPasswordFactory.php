<?php

namespace User\V1\Service;

use Laminas\ServiceManager\Factory\FactoryInterface;

class ResetPasswordFactory implements FactoryInterface
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
        $userMapper = $container->get(\Aqilix\OAuth2\Mapper\OauthUser::class);
        $resetPasswordMapper = $container->get(\User\Mapper\ResetPassword::class);

        return new ResetPassword(
            $userMapper,
            $resetPasswordMapper
        );
    }
}
