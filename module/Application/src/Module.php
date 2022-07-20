<?php

namespace Application;

use Laminas\ApiTools\ApiToolsModuleInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Uri\UriFactory;

class Module implements ApiToolsModuleInterface
{
    /**
     * Listen to application bootstrap event.
     *
     * - Attaches UnauthenticatedListener to authentication.post event.
     * - Attaches UnauthorizedListener to authorization.post event.
     * - Attaches module render listener to render event.
     *
     * @param  \Laminas\Mvc\MvcEvent  $e
     * @return void
     */
    public function onBootstrap(MvcEvent $e)
    {
        UriFactory::registerScheme('chrome-extension', \Laminas\Uri\Uri::class); // add chrome-extension for API Client

        $serviceManager = $e->getApplication()->getServiceManager();
        $eventManager = $e->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
    }

    /**
     * @return array<string,mixed>
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
