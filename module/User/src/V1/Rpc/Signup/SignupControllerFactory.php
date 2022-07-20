<?php

namespace User\V1\Rpc\Signup;

class SignupControllerFactory
{
    public function __invoke($controllers)
    {
        $signupValidator = $controllers->get('InputFilterManager')
            ->get('User\\V1\\Rpc\\Signup\\Validator');
        $signupService = $controllers->get(\User\V1\Service\Signup::class);

        return new SignupController(
            $signupValidator,
            $signupService
        );
    }
}
