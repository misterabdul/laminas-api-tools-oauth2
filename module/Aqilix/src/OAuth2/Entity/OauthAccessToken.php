<?php

namespace Aqilix\OAuth2\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * OauthAccessToken
 */
class OauthAccessToken implements EntityInterface
{
    /**
     * @var \DateTime
     */
    private $expires = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     */
    private $scope;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthClient
     */
    private $client;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthUser
     */
    private $user;


    /**
     * Set expires.
     *
     * @param \DateTime $expires
     *
     * @return OauthAccessToken
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Get expires.
     *
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Set scope.
     *
     * @param string|null $scope
     *
     * @return OauthAccessToken
     */
    public function setScope($scope = null)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope.
     *
     * @return string|null
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set accessToken.
     *
     * @param string $accessToken
     *
     * @return OauthAccessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set client.
     *
     * @param \Aqilix\OAuth2\Entity\OauthClient|null $client
     *
     * @return OauthAccessToken
     */
    public function setClient(\Aqilix\OAuth2\Entity\OauthClient $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client.
     *
     * @return \Aqilix\OAuth2\Entity\OauthClient|null
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set user.
     *
     * @param \Aqilix\OAuth2\Entity\OauthUser|null $user
     *
     * @return OauthAccessToken
     */
    public function setUser(\Aqilix\OAuth2\Entity\OauthUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Aqilix\OAuth2\Entity\OauthUser|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
