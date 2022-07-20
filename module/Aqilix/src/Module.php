<?php

namespace Aqilix;

use Laminas\Stdlib\ArrayUtils;

class Module
{
    /**
     * @param  \Laminas\Mvc\MvcEvent  $ev
     * @return void
     */
    public function onBootstrap($ev)
    {
        $serviceManager = $ev->getApplication()->getServiceManager();
        $eventManager = $ev->getApplication()->getEventManager();
        $em = $serviceManager->get('doctrine.entitymanager.orm_default');
        // enable soft-deletable
        $em->getFilters()
            ->enable('soft-deleteable');
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $config = [];
        $configFiles = [
            __DIR__ . '/../config/module.config.php',
            __DIR__ . '/../config/doctrine.oauth2.config.php',  // configuration for doctrine oauth2
        ];

        // merge all module config options
        foreach ($configFiles as $configFile) {
            $config = ArrayUtils::merge($config, include $configFile, true);
        }

        return $config;
    }
}
