<?php

namespace User\V1;

use Laminas\EventManager\Event;

class ProfileEvent extends Event
{
    public const EVENT_UPDATE_PROFILE = 'update.profile';
    public const EVENT_UPDATE_PROFILE_ERROR = 'update.profile.error';
    public const EVENT_UPDATE_PROFILE_SUCCESS = 'update.profile.success';

    /**
     * @var \User\Entity\UserProfile
     */
    protected $userProfileEntity;

    /**
     * @var \Laminas\InputFilter\InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var array
     */
    protected $updateData;

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
     * Get the value of inputFilter
     *
     * @return  \Laminas\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * Set the value of inputFilter
     *
     * @param  \Laminas\InputFilter\InputFilterInterface  $inputFilter
     *
     * @return  self
     */
    public function setInputFilter(\Laminas\InputFilter\InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;

        return $this;
    }

    /**
     * Get the value of updateData
     *
     * @return  array
     */
    public function getUpdateData()
    {
        return $this->updateData;
    }

    /**
     * Set the value of updateData
     *
     * @param  array  $updateData
     *
     * @return  self
     */
    public function setUpdateData(array $updateData)
    {
        $this->updateData = $updateData;

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
