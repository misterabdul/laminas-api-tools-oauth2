<?php

namespace User\V1;

use Laminas\EventManager\Event;

class ResetPasswordEvent extends Event
{
    public const EVENT_RESET_PASSWORD_CONFIRM_EMAIL = 'reset.password.confirm.email';
    public const EVENT_RESET_PASSWORD_CONFIRM_EMAIL_SUCCESS = 'reset.password.confirm.email.success';
    public const EVENT_RESET_PASSWORD_CONFIRM_EMAIL_ERROR   = 'reset.password.confirm.email.error';
    public const EVENT_RESET_PASSWORD_RESET = 'reset.password.reset';
    public const EVENT_RESET_PASSWORD_RESET_SUCCESS = 'reset.password.reset.success';
    public const EVENT_RESET_PASSWORD_RESET_ERROR   = 'reset.password.reset.error';

    /**
     * @var \User\Entity\ResetPassword
     */
    protected $resetPasswordEntity;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthUser
     */
    protected $userEntity;

    /**
     * @var string
     */
    protected $resetPasswordKey;

    /**
     * @var array
     */
    protected $resetPasswordData;

    /**
     * @var \Exception
     */
    protected $exception;


    /**
     * Get the value of resetPasswordEntity
     *
     * @return  \User\Entity\ResetPassword
     */
    public function getResetPasswordEntity()
    {
        return $this->resetPasswordEntity;
    }

    /**
     * Set the value of resetPasswordEntity
     *
     * @param  \User\Entity\ResetPassword  $resetPasswordEntity
     *
     * @return  self
     */
    public function setResetPasswordEntity(\User\Entity\ResetPassword $resetPasswordEntity)
    {
        $this->resetPasswordEntity = $resetPasswordEntity;

        return $this;
    }

    /**
     * Get the value of userEntity
     *
     * @return  \Aqilix\OAuth2\Entity\OauthUser
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     * Set the value of userEntity
     *
     * @param  \Aqilix\OAuth2\Entity\OauthUser  $userEntity
     *
     * @return  self
     */
    public function setUserEntity(\Aqilix\OAuth2\Entity\OauthUser $userEntity)
    {
        $this->userEntity = $userEntity;

        return $this;
    }

    /**
     * Get the value of resetPasswordKey
     *
     * @return  string
     */
    public function getResetPasswordKey()
    {
        return $this->resetPasswordKey;
    }

    /**
     * Set the value of resetPasswordKey
     *
     * @param  string  $resetPasswordKey
     *
     * @return  self
     */
    public function setResetPasswordKey(string $resetPasswordKey)
    {
        $this->resetPasswordKey = $resetPasswordKey;

        return $this;
    }

    /**
     * Get the value of resetPasswordData
     *
     * @return  array
     */
    public function getResetPasswordData()
    {
        return $this->resetPasswordData;
    }

    /**
     * Set the value of resetPasswordData
     *
     * @param  array  $resetPasswordData
     *
     * @return  self
     */
    public function setResetPasswordData(array $resetPasswordData)
    {
        $this->resetPasswordData = $resetPasswordData;

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
