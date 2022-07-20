<?php

namespace User\V1\Service;

use Laminas\EventManager\EventManagerAwareTrait;
use User\V1\ProfileEvent;

class Profile
{
    use EventManagerAwareTrait;

    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     */
    public function __construct($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    /**
     * Update User Profile
     *
     * @param  \User\Entity\UserProfile  $userProfile
     * @param  \Laminas\InputFilter\InputFilterInterface  $inputFilter
     */
    public function update($userProfile, $inputFilter)
    {
        $profileEvent = new ProfileEvent();
        $profileEvent->setUserProfileEntity($userProfile);
        $profileEvent->setUpdateData($inputFilter->getValues());
        $profileEvent->setInputFilter($inputFilter);
        $profileEvent->setName(ProfileEvent::EVENT_UPDATE_PROFILE);
        $update = $this->getEventManager()->triggerEvent($profileEvent);
        if ($update->stopped()) {
            $profileEvent->setName(ProfileEvent::EVENT_UPDATE_PROFILE_ERROR);
            $profileEvent->setException($update->last());
            $this->getEventManager()->triggerEvent($profileEvent);
            throw $profileEvent->getException();
        } else {
            $profileEvent->setName(ProfileEvent::EVENT_UPDATE_PROFILE_SUCCESS);
            $this->getEventManager()->triggerEvent($profileEvent);
        }
    }
}
