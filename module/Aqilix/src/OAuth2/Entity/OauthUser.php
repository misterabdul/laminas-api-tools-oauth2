<?php

namespace Aqilix\OAuth2\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * OauthUser
 */
class OauthUser implements EntityInterface
{
    /**
     * @var string|null
     */
    private $password;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var string
     */
    private $username;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $accessTokens;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $authorizationCodes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $refreshTokens;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accessTokens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->authorizationCodes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->refreshTokens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set password.
     *
     * @param string|null $password
     *
     * @return OauthUser
     */
    public function setPassword($password = null)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return OauthUser
     */
    public function setFirstName($firstName = null)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string|null $lastName
     *
     * @return OauthUser
     */
    public function setLastName($lastName = null)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return OauthUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Add accessToken.
     *
     * @param \Aqilix\OAuth2\Entity\OauthAccessToken $accessToken
     *
     * @return OauthUser
     */
    public function addAccessToken(\Aqilix\OAuth2\Entity\OauthAccessToken $accessToken)
    {
        $this->accessTokens[] = $accessToken;

        return $this;
    }

    /**
     * Remove accessToken.
     *
     * @param \Aqilix\OAuth2\Entity\OauthAccessToken $accessToken
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAccessToken(\Aqilix\OAuth2\Entity\OauthAccessToken $accessToken)
    {
        return $this->accessTokens->removeElement($accessToken);
    }

    /**
     * Get accessTokens.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccessTokens()
    {
        return $this->accessTokens;
    }

    /**
     * Add authorizationCode.
     *
     * @param \Aqilix\OAuth2\Entity\OauthAuthorizationCode $authorizationCode
     *
     * @return OauthUser
     */
    public function addAuthorizationCode(\Aqilix\OAuth2\Entity\OauthAuthorizationCode $authorizationCode)
    {
        $this->authorizationCodes[] = $authorizationCode;

        return $this;
    }

    /**
     * Remove authorizationCode.
     *
     * @param \Aqilix\OAuth2\Entity\OauthAuthorizationCode $authorizationCode
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAuthorizationCode(\Aqilix\OAuth2\Entity\OauthAuthorizationCode $authorizationCode)
    {
        return $this->authorizationCodes->removeElement($authorizationCode);
    }

    /**
     * Get authorizationCodes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAuthorizationCodes()
    {
        return $this->authorizationCodes;
    }

    /**
     * Add refreshToken.
     *
     * @param \Aqilix\OAuth2\Entity\OauthRefreshToken $refreshToken
     *
     * @return OauthUser
     */
    public function addRefreshToken(\Aqilix\OAuth2\Entity\OauthRefreshToken $refreshToken)
    {
        $this->refreshTokens[] = $refreshToken;

        return $this;
    }

    /**
     * Remove refreshToken.
     *
     * @param \Aqilix\OAuth2\Entity\OauthRefreshToken $refreshToken
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeRefreshToken(\Aqilix\OAuth2\Entity\OauthRefreshToken $refreshToken)
    {
        return $this->refreshTokens->removeElement($refreshToken);
    }

    /**
     * Get refreshTokens.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRefreshTokens()
    {
        return $this->refreshTokens;
    }
}
