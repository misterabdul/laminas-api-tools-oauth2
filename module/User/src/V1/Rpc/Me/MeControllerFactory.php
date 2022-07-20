<?php

namespace User\V1\Rpc\Me;

class MeControllerFactory
{
    public function __invoke($controllers)
    {
        $userProfileMapper = $controllers->get(\User\Mapper\UserProfile::class);
        $userProfileHydrator = $controllers->get('HydratorManager')
            ->get('User\\Hydrator\\UserProfile');

        return new MeController(
            $userProfileMapper,
            $userProfileHydrator
        );
    }
}
