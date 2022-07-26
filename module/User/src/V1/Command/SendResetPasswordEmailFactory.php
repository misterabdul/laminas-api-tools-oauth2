<?php

namespace User\V1\Command;

use Laminas\ServiceManager\Factory\FactoryInterface;

class SendResetPasswordEmailFactory implements FactoryInterface
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
        $config = $container->get('Config')['project']['sites'];
        $mailTransport = $container->get('Aqilix\Service\Mail');
        $resetPasswordMailMessage = $container->get('User\\V1\\Notification\\Email\\Service\\ResetPassword');
        $viewRenderer = $container->get('ViewRenderer');
        $logger = $container->get("logger_default");

        return new SendResetPasswordEmail(
            $config,
            $mailTransport,
            $resetPasswordMailMessage,
            $viewRenderer,
            $logger
        );
    }
}
