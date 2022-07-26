<?php

namespace Aqilix\OAuth2\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * OauthAuthorizationCode
 */
class OauthAuthorizationCode implements EntityInterface
{
    /**
     * @var string|null
     */
    private $redirectUri;

    /**
     * @var \DateTime
     */
    private $expires = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     */
    private $scope;

    /**
     * @var string|null
     */
    private $idToken;

    /**
     * @var string
     */
    private $authorizationCode;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthClient
     */
    private $client;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthUser
     */
    private $user;


    /**
     * Set redirectUri.
     *
     * @param string|null $redirectUri
     *
     * @return OauthAuthorizationCode
     */
    public function setRedirectUri($redirectUri = null)
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    /**
     * Get redirectUri.
     *
     * @return string|null
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Set expires.
     *
     * @param \DateTime $expires
     *
     * @return OauthAuthorizationCode
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
     * @return OauthAuthorizationCode
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
     * Set idToken.
     *
     * @param string|null $idToken
     *
     * @return OauthAuthorizationCode
     */
    public function setIdToken($idToken = null)
    {
        $this->idToken = $idToken;

        return $this;
    }

    /**
     * Get idToken.
     *
     * @return string|null
     */
    public function getIdToken()
    {
        return $this->idToken;
    }

    /**
     * Get authorizationCode.
     *
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * Set client.
     *
     * @param \Aqilix\OAuth2\Entity\OauthClient|null $client
     *
     * @return OauthAuthorizationCode
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
     * @return OauthAuthorizationCode
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
