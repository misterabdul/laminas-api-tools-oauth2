<?php

namespace Aqilix\Service\Mail;

use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Mailgun SMTP Transport Object
 *
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 */
class MailgunAppFactory implements FactoryInterface
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
        $config  = $container->get('Config')['mail']['transport']['mailgunapp'];
        $transport = new SmtpTransport();
        $options   = new SmtpOptions($config['options']);
        $transport->setOptions($options);

        return $transport;
    }
}
