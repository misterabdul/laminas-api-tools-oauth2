<?php

/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2016 IsItUp.com
 * @author    Dolly Aswin <dolly.aswin@gmail.com>
 */

namespace User\OAuth2\Adapter;

use Laminas\ApiTools\OAuth2\Adapter\PdoAdapter as LaminasPdoAdapter;
use Laminas\ApiTools\MvcAuth\Identity\AuthenticatedIdentity;
use Laminas\ApiTools\MvcAuth\Identity\GuestIdentity;
use Laminas\ApiTools\MvcAuth\MvcAuthEvent;
use Laminas\Authentication\Result;

/**
 * Extension of OAuth2\Storage\PDO with EventManager
 */
class PdoAdapter extends LaminasPdoAdapter
{
    /**
     * @var \Laminas\EventManager\EventManager
     */
    protected $eventManager;

    /**
     * @var \Laminas\ApiTools\MvcAuth\MvcAuthEvent
     */
    protected $mvcAuthEvent;

    /**
     * @param  string  $connection
     * @param  array  $config
     */
    public function __construct($connection, $config)
    {
        parent::__construct($connection, $config);
    }

    /**
     * Check password using bcrypt
     *
     * @param  string  $user
     * @param  string  $password
     * @return bool
     */
    protected function checkPassword($user, $password)
    {
        $event = $this->mvcAuthEvent;
        $event->setAuthenticationResult(new Result(Result::SUCCESS, $user['user_id']));
        $event->setIdentity(new AuthenticatedIdentity($event->getAuthenticationResult()->getIdentity()));
        $event->setName(MvcAuthEvent::EVENT_AUTHENTICATION);
        $this->eventManager->triggerEvent($event);

        $verified = parent::verifyHash($password, $user['password']);
        if (!$verified) {
            $event->setAuthenticationResult(new Result(Result::FAILURE_CREDENTIAL_INVALID, null));
            $event->setIdentity(new GuestIdentity());
        }

        $event->setName(MvcAuthEvent::EVENT_AUTHENTICATION_POST);
        $this->eventManager->triggerEvent($event);

        return $verified;
    }


    /**
     * Get the value of eventManager
     *
     * @return  \Laminas\EventManager\EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * Set the value of eventManager
     *
     * @param  \Laminas\EventManager\EventManager  $eventManager
     *
     * @return  self
     */
    public function setEventManager(\Laminas\EventManager\EventManager $eventManager)
    {
        $this->eventManager = $eventManager;

        return $this;
    }

    /**
     * Get the value of mvcAuthEvent
     *
     * @return  \Laminas\ApiTools\MvcAuth\MvcAuthEvent
     */
    public function getMvcAuthEvent()
    {
        return $this->mvcAuthEvent;
    }

    /**
     * Set the value of mvcAuthEvent
     *
     * @param  \Laminas\ApiTools\MvcAuth\MvcAuthEvent  $mvcAuthEvent
     *
     * @return  self
     */
    public function setMvcAuthEvent(\Laminas\ApiTools\MvcAuth\MvcAuthEvent $mvcAuthEvent)
    {
        $this->mvcAuthEvent = $mvcAuthEvent;

        return $this;
    }
}
