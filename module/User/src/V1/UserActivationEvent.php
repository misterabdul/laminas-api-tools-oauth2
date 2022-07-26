<?php

namespace User\V1;

use Laminas\EventManager\Event;

class UserActivationEvent extends Event
{
    public const EVENT_ACTIVATE_USER = 'activate.user';
    public const EVENT_ACTIVATE_USER_SUCCESS = 'activate.user.success';
    public const EVENT_ACTIVATE_USER_ERROR   = 'activate.user.error';

    /**
     * @var \User\Entity\UserProfile
     */
    protected $userProfileEntity;

    /**
     * @var \User\Entity\UserActivation
     */
    protected $userActivationEntity;

    /**
     * @var array
     */
    protected $userActivationData;

    /**
     * @var string
     */
    protected $userActivationUuid;

    /**
     * @var \Exception
     */
    protected $exception;


    /**
     * Get the value of userProfileEntity
     *
     * @return  \User\Entity\UserProfile
     */
    public function getUserProfileEntity()
    {
        return $this->userProfileEntity;
    }

    /**
     * Set the value of userProfileEntity
     *
     * @param  \User\Entity\UserProfile  $userProfileEntity
     *
     * @return  self
     */
    public function setUserProfileEntity(\User\Entity\UserProfile $userProfileEntity)
    {
        $this->userProfileEntity = $userProfileEntity;

        return $this;
    }

    /**
     * Get the value of userActivationEntity
     *
     * @return  \User\Entity\UserActivation
     */
    public function getUserActivationEntity()
    {
        return $this->userActivationEntity;
    }

    /**
     * Set the value of userActivationEntity
     *
     * @param  \User\Entity\UserActivation  $userActivationEntity
     *
     * @return  self
     */
    public function setUserActivationEntity(\User\Entity\UserActivation $userActivationEntity)
    {
        $this->userActivationEntity = $userActivationEntity;

        return $this;
    }

    /**
     * Get the value of userActivationData
     *
     * @return  array
     */
    public function getUserActivationData()
    {
        return $this->userActivationData;
    }

    /**
     * Set the value of userActivationData
     *
     * @param  array  $userActivationData
     *
     * @return  self
     */
    public function setUserActivationData(array $userActivationData)
    {
        $this->userActivationData = $userActivationData;

        return $this;
    }

    /**
     * Get the value of userActivationUuid
     *
     * @return  string
     */
    public function getUserActivationUuid()
    {
        return $this->userActivationUuid;
    }

    /**
     * Set the value of userActivationUuid
     *
     * @param  string  $userActivationUuid
     *
     * @return  self
     */
    public function setUserActivationUuid(string $userActivationUuid)
    {
        $this->userActivationUuid = $userActivationUuid;

        return $this;
    }

    /**
     * Get the value of exception
     *
     * @return  \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Set the value of exception
     *
     * @param  \Exception  $exception
     *
     * @return  self
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }
}
