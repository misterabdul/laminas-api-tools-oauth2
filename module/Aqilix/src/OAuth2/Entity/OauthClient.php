<?php

namespace Aqilix\OAuth2\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * OauthClient
 */
class OauthClient implements EntityInterface
{
    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var string|null
     */
    private $grantTypes;

    /**
     * @var string|null
     */
    private $scope;

    /**
     * @var string|null
     */
    private $userId;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthJwt
     */
    private $jwt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $scopes;

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
        $this->scopes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accessTokens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->authorizationCodes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->refreshTokens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set clientSecret.
     *
     * @param string $clientSecret
     *
     * @return OauthClient
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * Get clientSecret.
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Set redirectUri.
     *
     * @param string $redirectUri
     *
     * @return OauthClient
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    /**
     * Get redirectUri.
     *
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Set grantTypes.
     *
     * @param string|null $grantTypes
     *
     * @return OauthClient
     */
    public function setGrantTypes($grantTypes = null)
    {
        $this->grantTypes = $grantTypes;

        return $this;
    }

    /**
     * Get grantTypes.
     *
     * @return string|null
     */
    public function getGrantTypes()
    {
        return $this->grantTypes;
    }

    /**
     * Set scope.
     *
     * @param string|null $scope
     *
     * @return OauthClient
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
     * Set userId.
     *
     * @param string|null $userId
     *
     * @return OauthClient
     */
    public function setUserId($userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return string|null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set clientId.
     *
     * @param string $clientId
     *
     * @return OauthClient
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId.
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set jwt.
     *
     * @param \Aqilix\OAuth2\Entity\OauthJwt|null $jwt
     *
     * @return OauthClient
     */
    public function setJwt(\Aqilix\OAuth2\Entity\OauthJwt $jwt = null)
    {
        $this->jwt = $jwt;

        return $this;
    }

    /**
     * Get jwt.
     *
     * @return \Aqilix\OAuth2\Entity\OauthJwt|null
     */
    public function getJwt()
    {
        return $this->jwt;
    }

    /**
     * Add scope.
     *
     * @param \Aqilix\OAuth2\Entity\OauthScope $scope
     *
     * @return OauthClient
     */
    public function addScope(\Aqilix\OAuth2\Entity\OauthScope $scope)
    {
        $this->scopes[] = $scope;

        return $this;
    }

    /**
     * Remove scope.
     *
     * @param \Aqilix\OAuth2\Entity\OauthScope $scope
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeScope(\Aqilix\OAuth2\Entity\OauthScope $scope)
    {
        return $this->scopes->removeElement($scope);
    }

    /**
     * Get scopes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Add accessToken.
     *
     * @param \Aqilix\OAuth2\Entity\OauthAccessToken $accessToken
     *
     * @return OauthClient
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
     * @return OauthClient
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
     * @return OauthClient
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
