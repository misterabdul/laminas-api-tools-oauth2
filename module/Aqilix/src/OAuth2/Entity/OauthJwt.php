<?php

namespace Aqilix\OAuth2\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * OauthJwt
 */
class OauthJwt implements EntityInterface
{
    /**
     * @var string|null
     */
    private $subject;

    /**
     * @var string|null
     */
    private $publicKey;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthClient
     */
    private $client;


    /**
     * Set subject.
     *
     * @param string|null $subject
     *
     * @return OauthJwt
     */
    public function setSubject($subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set publicKey.
     *
     * @param string|null $publicKey
     *
     * @return OauthJwt
     */
    public function setPublicKey($publicKey = null)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * Get publicKey.
     *
     * @return string|null
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Set client.
     *
     * @param \Aqilix\OAuth2\Entity\OauthClient $client
     *
     * @return OauthJwt
     */
    public function setClient(\Aqilix\OAuth2\Entity\OauthClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client.
     *
     * @return \Aqilix\OAuth2\Entity\OauthClient
     */
    public function getClient()
    {
        return $this->client;
    }
}
