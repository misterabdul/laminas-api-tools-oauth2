<?php

namespace User\V1\Service;

use Laminas\EventManager\EventManagerAwareTrait;
use User\V1\SignupEvent;

class Signup
{
    use EventManagerAwareTrait;

    /**
     * Register new user
     *
     * @param  array  $signupData
     * @return void
     * @throws \RuntimeException
     */
    public function register($signupData)
    {
        $signupEvent = new SignupEvent();
        $signupEvent->setSignupData($signupData);
        $signupEvent->setName(SignupEvent::EVENT_INSERT_USER);
        $insert = $this->getEventManager()->triggerEvent($signupEvent);
        if ($insert->stopped()) {
            $signupEvent->setException($insert->last());
            $signupEvent->setName(SignupEvent::EVENT_INSERT_USER_ERROR);
            $insert = $this->getEventManager()->triggerEvent($signupEvent);
            throw $signupEvent->getException();
        } else {
            $signupEvent->setName(SignupEvent::EVENT_INSERT_USER_SUCCESS);
            $this->getEventManager()->triggerEvent($signupEvent);
        }
    }
}
