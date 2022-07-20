<?php

namespace User\V1\Rpc\ResetPasswordNewPassword;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\ApiProblemResponse;
use Laminas\ApiTools\Hal\View\HalJsonModel;
use Laminas\Json\Json;
use Laminas\Mvc\Controller\AbstractActionController;

class ResetPasswordNewPasswordController extends AbstractActionController
{
    /**
     * @var \Laminas\InputFilter\InputFilterInterface
     */
    protected $confirmNewPasswordValidator;

    /**
     * @var \User\V1\Service\ResetPassword
     */
    protected $resetPasswordService;

    /**
     * @param  \Laminas\InputFilter\InputFilterInterface  $confirmNewPasswordValidator
     * @param  \User\V1\Service\ResetPassword
     */
    public function __construct(
        $confirmNewPasswordValidator,
        $resetPasswordService
    ) {
        $this->confirmNewPasswordValidator = $confirmNewPasswordValidator;
        $this->resetPasswordService = $resetPasswordService;
    }

    /**
     * @return mixed
     */
    public function resetPasswordNewPasswordAction()
    {
        try {
            $this->confirmNewPasswordValidator
                ->setData(Json::decode($this->getRequest()->getContent(), true));
            $this->resetPasswordService
                ->reset($this->confirmNewPasswordValidator->getValues());

            return new HalJsonModel([]);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(
                422,
                "Failed Validation",
                null,
                null,
                ['validation_messages' => ['resetPasswordKey' => [$e->getMessage()]]]
            ));
        }
    }
}
