<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;
use Gedmo\Timestampable\Traits\Timestampable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;

/**
 * UserProfile
 */
class UserProfile implements EntityInterface
{
    use Timestampable,
        SoftDeleteable;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var \DateTime|null
     */
    private $dateOfBirth;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $province;

    /**
     * @var string|null
     */
    private $postalCode;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var string|null
     */
    private $photo;

    /**
     * @var bool
     */
    private $isActive = '0';

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthUser
     */
    private $user;

    /**
     * @var \User\Entity\UserActivation
     */
    private $userActivation;


    /**
     * Set firstName.
     *
     * @param string|null $firstName
     *
     * @return UserProfile
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
     * @return UserProfile
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
     * Set dateOfBirth.
     *
     * @param \DateTime|null $dateOfBirth
     *
     * @return UserProfile
     */
    public function setDateOfBirth($dateOfBirth = null)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth.
     *
     * @return \DateTime|null
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set address.
     *
     * @param string|null $address
     *
     * @return UserProfile
     */
    public function setAddress($address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city.
     *
     * @param string|null $city
     *
     * @return UserProfile
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set province.
     *
     * @param string|null $province
     *
     * @return UserProfile
     */
    public function setProvince($province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province.
     *
     * @return string|null
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set postalCode.
     *
     * @param string|null $postalCode
     *
     * @return UserProfile
     */
    public function setPostalCode($postalCode = null)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode.
     *
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set country.
     *
     * @param string|null $country
     *
     * @return UserProfile
     */
    public function setCountry($country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set photo.
     *
     * @param string|null $photo
     *
     * @return UserProfile
     */
    public function setPhoto($photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo.
     *
     * @return string|null
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return UserProfile
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
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
     * @return UserProfile
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

    /**
     * Set userActivation.
     *
     * @param \User\Entity\UserActivation|null $userActivation
     *
     * @return UserProfile
     */
    public function setUserActivation(\User\Entity\UserActivation $userActivation = null)
    {
        $this->userActivation = $userActivation;

        return $this;
    }

    /**
     * Get userActivation.
     *
     * @return \User\Entity\UserActivation|null
     */
    public function getUserActivation()
    {
        return $this->userActivation;
    }
}
