<?php

namespace Aqilix\OAuth2\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * OauthScope
 */
class OauthScope implements EntityInterface
{
    /**
     * @var string
     */
    private $type = 'supported';

    /**
     * @var string|null
     */
    private $scope;

    /**
     * @var int|null
     */
    private $isDefault;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthClient
     */
    private $client;


    /**
     * Set type.
     *
     * @param string $type
     *
     * @return OauthScope
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set scope.
     *
     * @param string|null $scope
     *
     * @return OauthScope
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
     * Set isDefault.
     *
     * @param int|null $isDefault
     *
     * @return OauthScope
     */
    public function setIsDefault($isDefault = null)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault.
     *
     * @return int|null
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set client.
     *
     * @param \Aqilix\OAuth2\Entity\OauthClient|null $client
     *
     * @return OauthScope
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
}
