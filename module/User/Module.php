<?php

namespace User;

use Laminas\ApiTools\MvcAuth\MvcAuthEvent;
use Laminas\ApiTools\Provider\ApiToolsProviderInterface;
use Laminas\ModuleManager\Feature\AutoloaderProviderInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Stdlib\ArrayUtils;

class Module implements
    ApiToolsProviderInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface
{
    /**
     * @param  \Laminas\Mvc\MvcEvent  $ev
     * @return void
     */
    public function onBootstrap($ev)
    {
        $serviceManager = $ev->getApplication()->getServiceManager();

        // profile
        $profileService = $serviceManager->get(\User\V1\Service\Profile::class);
        $profileEventListener = $serviceManager->get(\User\V1\Service\Listener\ProfileEventListener::class);
        $profileEventListener->attach($profileService->getEventManager());

        // signup
        $signupService  = $serviceManager->get(\User\V1\Service\Signup::class);
        $signupEventListener = $serviceManager->get(\User\V1\Service\Listener\SignupEventListener::class);
        $signupEventListener->attach($signupService->getEventManager());

        // notification email for signup
        $signupNotificationEmailListener = $serviceManager->get(\User\V1\Notification\Email\Listener\SignupEventListener::class);
        $signupNotificationEmailListener->attach($signupService->getEventManager());

        // user activation
        $userActivationService = $serviceManager->get(\User\V1\Service\UserActivation::class);
        $userActivationEventListener = $serviceManager->get(\User\V1\Service\Listener\UserActivationEventListener::class);
        $userActivationEventListener->attach($userActivationService->getEventManager());

        // notification email for activation
        $activationNotificationEmailListener = $serviceManager->get(\User\V1\Notification\Email\Listener\ActivationEventListener::class);
        $activationNotificationEmailListener->attach($userActivationService->getEventManager());

        // reset password
        $resetPasswordService = $serviceManager->get(\User\V1\Service\ResetPassword::class);
        $resetPasswordEventListener = $serviceManager->get(\User\V1\Service\Listener\ResetPasswordEventListener::class);
        $resetPasswordEventListener->attach($resetPasswordService->getEventManager());

        // notification email for reset password
        $resetPasswordNotificationEmailListener = $serviceManager->get(\User\V1\Notification\Email\Listener\ResetPasswordEventListener::class);
        $resetPasswordNotificationEmailListener->attach($resetPasswordService->getEventManager());

        // AuthActiveUserListener
        $mvcAuthEvent = new MvcAuthEvent(
            $ev,
            $serviceManager->get('authentication'),
            $serviceManager->get('authorization')
        );
        $app = $ev->getApplication();
        $events = $app->getEventManager();
        $pdoAdapter = $serviceManager->get(\User\OAuth2\Adapter\PdoAdapter::class);
        $pdoAdapter->setEventManager($events);
        $pdoAdapter->setMvcAuthEvent($mvcAuthEvent);

        $events->attach(
            MvcAuthEvent::EVENT_AUTHENTICATION_POST,
            $serviceManager->get(\User\Service\Listener\AuthActiveUserListener::class)
        );
        // add header if get http status 401
        $events->attach(
            MvcEvent::EVENT_FINISH,
            $serviceManager->get(\User\Service\Listener\UnauthorizedUserListener::class),
            -100
        );
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $config = [];
        $configFiles = [
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/doctrine.config.php',  // configuration for doctrine
        ];

        // merge all module config options
        foreach ($configFiles as $configFile) {
            $config = ArrayUtils::merge($config, include $configFile, true);
        }

        return $config;
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            \Laminas\ApiTools\Autoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }
}
