<?php

namespace User\Controller;

use Laminas\ApiTools\MvcAuth\Identity\AuthenticatedIdentity;

trait UserFetchable
{
    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * Get UserProfile
     *
     * @return \User\Entity\UserProfile|null
     */
    public function fetchUserProfile()
    {
        $identity = $this->getIdentity();
        if ($identity instanceof AuthenticatedIdentity) {
            $identityArray = $identity->getAuthenticationIdentity();
            $userId = $identityArray['user_id'] ?? null;

            if ($userId !== null)
                return $this->userProfileMapper
                    ->fetchOneByOauthUsername(['username' => $userId]);
        }

        return null;
    }
}
