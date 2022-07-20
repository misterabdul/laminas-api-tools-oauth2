<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timestampable\Traits\Timestampable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;

/**
 * UserProfile
 */
class UserActivation implements EntityInterface
{
    use Timestampable,
        SoftDeleteable;

    /**
     * @var \DateTime
     */
    private $expiration;

    /**
     * @var \DateTime|null
     */
    private $activated;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthUser
     */
    private $user;


    /**
     * Set expiration.
     *
     * @param \DateTime $expiration
     *
     * @return UserActivation
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Get expiration.
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Set activated.
     *
     * @param \DateTime|null $activated
     *
     * @return UserActivation
     */
    public function setActivated($activated = null)
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * Get activated.
     *
     * @return \DateTime|null
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set user.
     *
     * @param \Aqilix\OAuth2\Entity\OauthUser|null $user
     *
     * @return UserActivation
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
