<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timestampable\Traits\Timestampable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;

/**
 * ResetPassword
 */
class ResetPassword implements EntityInterface
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
    private $reseted;

    /**
     * @var string|null
     */
    private $password;

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
     * @return ResetPassword
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
     * Set reseted.
     *
     * @param \DateTime|null $reseted
     *
     * @return ResetPassword
     */
    public function setReseted($reseted = null)
    {
        $this->reseted = $reseted;

        return $this;
    }

    /**
     * Get reseted.
     *
     * @return \DateTime|null
     */
    public function getReseted()
    {
        return $this->reseted;
    }

    /**
     * Set password.
     *
     * @param string|null $password
     *
     * @return ResetPassword
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
     * @return ResetPassword
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
