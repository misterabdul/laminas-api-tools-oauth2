<?php

namespace User\V1\Service;

use Laminas\EventManager\EventManagerAwareTrait;
use User\V1\UserActivationEvent;

class UserActivation
{
    use EventManagerAwareTrait;

    /**
     * @var \User\Mapper\UserActivation
     */
    protected $userActivationMapper;

    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * Construct
     *
     * @param  \User\Mapper\UserProfile     $userProfileMapper
     * @param  \User\Mapper\UserActivation  $userActivationMapper
     */
    public function __construct(
        $userProfileMapper,
        $userActivationMapper
    ) {
        $this->userActivationMapper = $userActivationMapper;
        $this->userProfileMapper = $userProfileMapper;
    }

    /**
     * Activate user
     *
     * @param  array  $activationData
     * @return void
     * @throws  \RuntimeException
     */
    public function activate($activationData)
    {
        $userActivationEvent = new UserActivationEvent();
        $userActivationEvent->setUserActivationData($activationData);
        // retrieve user activation
        $activation  = $this->userActivationMapper
            ->fetchOne($activationData['activationUuid']);
        // check if activation data exist
        if (is_null($activation)) {
            throw new \RuntimeException('Activation UUID not valid');
        }

        // retrieve user
        $user = $activation->getUser();
        // retrieve user profile
        $userProfile = $this->userProfileMapper
            ->fetchOneBy(['user' => $user->getUsername()]);
        $userActivationEvent->setUserProfileEntity($userProfile);
        $userActivationEvent->setUserActivationEntity($activation);
        $userActivationEvent->setName(UserActivationEvent::EVENT_ACTIVATE_USER);
        $activate = $this->getEventManager()->triggerEvent($userActivationEvent);
        if ($activate->stopped()) {
            $userActivationEvent->setException($activate->last());
            $userActivationEvent->setName(UserActivationEvent::EVENT_ACTIVATE_USER_ERROR);
            $this->getEventManager()->triggerEvent($userActivationEvent);
            throw $userActivationEvent->getException();
        } else {
            $userActivationEvent->setName(UserActivationEvent::EVENT_ACTIVATE_USER_SUCCESS);
            $this->getEventManager()->triggerEvent($userActivationEvent);
        }
    }
}
