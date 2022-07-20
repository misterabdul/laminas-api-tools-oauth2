<?php

namespace User\V1\Fixture;

use Aqilix\OAuth2\Entity\OauthUser as OauthUserEntity;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Laminas\Crypt\Password\Bcrypt;

// class LoadUserData implements FixtureInterface
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        return 0;
    }

    /**
     * @param  \Doctrine\Persistence\ObjectManager  $manager
     * @return void
     */
    public function load($manager)
    {
        $bcrypt   = new Bcrypt();
        $password = $bcrypt->create('12345678');

        $userData = [
            [
                'username'  => 'dolly.aswin@aqilix.com',
                'password'  => $password,
                'firstName' => 'Dolly Aswin',
                'lastName'  => 'Harahap'
            ]
        ];

        foreach ($userData as $key => $data) {
            $user[$key] = new OauthUserEntity();
            $user[$key]->setUsername($data['username']);
            $user[$key]->setPassword($data['password']);
            $user[$key]->setFirstName($data['firstName']);
            $user[$key]->setLastName($data['lastName']);
            $manager->persist($user[$key]);
        }

        $manager->flush();
        foreach ($userData as $key => $data) {
            $this->addReference('user' . $key, $user[$key]);
        }
    }
}
