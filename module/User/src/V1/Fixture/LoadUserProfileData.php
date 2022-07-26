<?php

namespace User\V1\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use User\Entity\UserProfile as UserProfileEntity;

class LoadUserProfileData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * @param  \Doctrine\Persistence\ObjectManager  $manager
     * @return void
     */
    public function load($manager)
    {
        $userProfileData = [
            'firstName'     => 'Dolly Aswin',
            'lastName'      => 'Harahap',
            'address'       => 'Medan',
            'city'          => 'Medan',
            'province'      => 'North Sumatera',
            'postalCode'    => '20000',
            'country'       => 'ID',
            'user'          => $this->getReference('user0')
        ];

        $userProfile = new UserProfileEntity();
        $userProfile->setFirstName($userProfileData['firstName']);
        $userProfile->setLastName($userProfileData['lastName']);
        $userProfile->setAddress($userProfileData['address']);
        $userProfile->setCity($userProfileData['city']);
        $userProfile->setProvince($userProfileData['province']);
        $userProfile->setPostalCode($userProfileData['postalCode']);
        $userProfile->setCountry($userProfileData['country']);
        $userProfile->setUser($userProfileData['user']);

        $manager->persist($userProfile);
        $manager->flush();
    }
}
