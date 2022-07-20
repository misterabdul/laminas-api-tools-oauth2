<?php

namespace Aqilix\OAuth2\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * OauthRefreshToken
 */
class OauthRefreshToken implements EntityInterface
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
    private $refreshToken;

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
     * @return OauthRefreshToken
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
     * @return OauthRefreshToken
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
     * Set refreshToken.
     *
     * @param string $refreshToken
     *
     * @return OauthRefreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * Get refreshToken.
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Set client.
     *
     * @param \Aqilix\OAuth2\Entity\OauthClient|null $client
     *
     * @return OauthRefreshToken
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
     * @return OauthRefreshToken
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
