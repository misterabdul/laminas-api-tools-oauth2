<?php

namespace User\V1\Rpc\ResetPasswordConfirmEmail;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\ApiProblemResponse;
use Laminas\ApiTools\Hal\View\HalJsonModel;
use Laminas\Json\Json;
use Laminas\Mvc\Controller\AbstractActionController;

class ResetPasswordConfirmEmailController extends AbstractActionController
{
    /**
     * @var \Laminas\InputFilter\InputFilterInterface
     */
    protected $confirmEmailValidator;

    /**
     * @var \User\V1\Service\ResetPassword
     */
    protected $resetPasswordService;

    /**
     * @param  \Laminas\Validator\ValidatorInterface  $confirmEmailValidator
     * @param  \User\V1\Service\ResetPassword  $resetPasswordService
     */
    public function __construct(
        $confirmEmailValidator,
        $resetPasswordService
    ) {
        $this->confirmEmailValidator = $confirmEmailValidator;
        $this->resetPasswordService = $resetPasswordService;
    }

    /**
     * @return mixed
     */
    public function resetPasswordConfirmEmailAction()
    {
        try {
            $this->confirmEmailValidator
                ->setData(Json::decode($this->getRequest()->getContent(), true));
            $this->resetPasswordService
                ->create($this->confirmEmailValidator->getValues());

            return new HalJsonModel([]);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(
                422,
                "Failed Validation",
                null,
                null,
                ['validation_messages' => ['emailAddress' => [$e->getMessage()]]]
            ));
        }
    }
}
