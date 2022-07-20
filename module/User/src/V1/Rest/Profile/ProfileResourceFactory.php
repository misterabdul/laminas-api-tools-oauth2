<?php

namespace User\V1\Rest\Profile;

class ProfileResourceFactory
{
    public function __invoke($services)
    {
        $userProfileMapper = $services->get(\User\Mapper\UserProfile::class);
        $userProfileService = $services->get(\User\V1\Service\Profile::class);

        return new ProfileResource(
            $userProfileMapper,
            $userProfileService
        );
    }
}
