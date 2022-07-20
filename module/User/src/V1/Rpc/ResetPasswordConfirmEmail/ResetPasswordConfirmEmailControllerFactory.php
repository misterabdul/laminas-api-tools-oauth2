<?php

namespace User\V1\Rpc\ResetPasswordConfirmEmail;

class ResetPasswordConfirmEmailControllerFactory
{
    public function __invoke($controllers)
    {
        $confirmEmailValidator = $controllers->get('InputFilterManager')
            ->get('User\\V1\\Rpc\\ResetPasswordConfirmEmail\\Validator');
        $resetPasswordService  = $controllers->get(\User\V1\Service\ResetPassword::class);

        return new ResetPasswordConfirmEmailController(
            $confirmEmailValidator,
            $resetPasswordService
        );
    }
}
