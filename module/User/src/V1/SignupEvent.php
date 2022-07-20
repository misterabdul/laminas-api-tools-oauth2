<?php

namespace User\V1;

use Laminas\EventManager\Event;

class SignupEvent extends Event
{
    public const EVENT_INSERT_USER = 'insert.user';
    public const EVENT_INSERT_USER_SUCCESS = 'insert.user.success';
    public const EVENT_INSERT_USER_ERROR   = 'insert.user.error';

    /**
     * @var \Aqilix\OAuth2\Entity\OauthUser
     */
    protected $userEntity;

    /**
     * @var array
     */
    protected $signupData;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @var string
     */
    protected $userActivationKey;

    /**
     * @var string
     */
    protected $userActivationUrl;

    /**
     * @var string
     */
    protected $userActivationMessage;

    /**
     * @var array
     */
    protected $accessTokenResponse;


    /**
     * Get the value of userEntity
     *
     * @return \Aqilix\OAuth2\Entity\OauthUser
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
     * Get the value of signupData
     *
     * @return  array
     */
    public function getSignupData()
    {
        return $this->signupData;
    }

    /**
     * Set the value of signupData
     *
     * @param  array  $signupData
     *
     * @return  self
     */
    public function setSignupData(array $signupData)
    {
        $this->signupData = $signupData;

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

    /**
     * Get the value of userActivationKey
     *
     * @return  string
     */
    public function getUserActivationKey()
    {
        return $this->userActivationKey;
    }

    /**
     * Set the value of userActivationKey
     *
     * @param  string  $userActivationKey
     *
     * @return  self
     */
    public function setUserActivationKey(string $userActivationKey)
    {
        $this->userActivationKey = $userActivationKey;

        return $this;
    }

    /**
     * Get the value of userActivationUrl
     *
     * @return  string
     */
    public function getUserActivationUrl()
    {
        return $this->userActivationUrl;
    }

    /**
     * Set the value of userActivationUrl
     *
     * @param  string  $userActivationUrl
     *
     * @return  self
     */
    public function setUserActivationUrl(string $userActivationUrl)
    {
        $this->userActivationUrl = $userActivationUrl;

        return $this;
    }

    /**
     * Get the value of userActivationMessage
     *
     * @return  string
     */
    public function getUserActivationMessage()
    {
        return $this->userActivationMessage;
    }

    /**
     * Set the value of userActivationMessage
     *
     * @param  string  $userActivationMessage
     *
     * @return  self
     */
    public function setUserActivationMessage(string $userActivationMessage)
    {
        $this->userActivationMessage = $userActivationMessage;

        return $this;
    }

    /**
     * Get the value of accessTokenResponse
     *
     * @return  array
     */
    public function getAccessTokenResponse()
    {
        return $this->accessTokenResponse;
    }

    /**
     * Set the value of accessTokenResponse
     *
     * @param  array  $accessTokenResponse
     *
     * @return  self
     */
    public function setAccessTokenResponse(array $accessTokenResponse)
    {
        $this->accessTokenResponse = $accessTokenResponse;

        return $this;
    }
}
