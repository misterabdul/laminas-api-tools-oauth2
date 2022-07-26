<?php

namespace User\V1\Rpc\UserActivation;

class UserActivationControllerFactory
{
    public function __invoke($controllers)
    {
        $userActivationValidator = $controllers->get('InputFilterManager')
            ->get('User\\V1\\Rpc\\UserActivation\\Validator');
        $userActivationService = $controllers->get(\User\V1\Service\UserActivation::class);

        return new UserActivationController(
            $userActivationValidator,
            $userActivationService
        );
    }
}
