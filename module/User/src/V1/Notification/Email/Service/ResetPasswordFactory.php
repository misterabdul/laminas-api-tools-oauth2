<?php

namespace User\V1\Notification\Email\Service;

use Laminas\Mail\Message;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Message Object For Notification Email
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
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
        $config  = $container->get('Config')['user']['email']['reset_password'];
        $message = new Message();
        $message->addFrom($config['from'], $config['name'])
            ->setSubject($config['subject']);

        return $message;
    }
}
