<?php

namespace User\V1\Rpc\Signup;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\ApiProblemResponse;
use Laminas\ApiTools\Hal\View\HalJsonModel;
use Laminas\Json\Json;
use Laminas\Mvc\Controller\AbstractActionController;

class SignupController extends AbstractActionController
{
    /**
     * @var \Laminas\InputFilter\InputFilterInterface
     */
    protected $signupValidator;

    /**
     * @var \User\V1\Service\Signup
     */
    protected $signupService;

    /**
     * @param  \Laminas\InputFilter\InputFilterInterface  $signupValidator
     * @param  \User\V1\Service\Signup  $signupService
     */
    public function __construct(
        $signupValidator,
        $signupService
    ) {
        $this->signupValidator = $signupValidator;
        $this->signupService = $signupService;
    }

    /**
     * @return mixed
     */
    public function signupAction()
    {
        try {
            $this->signupValidator
                ->setData(Json::decode($this->getRequest()->getContent(), true));
            $this->signupService
                ->register($this->signupValidator->getValues());

            return new HalJsonModel($this->signupService->getSignupEvent()->getAccessTokenResponse());
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(
                422,
                "Failed Validation",
                null,
                null,
                ['validation_messages' => ['email' => ['Email Address has been used']]]
            ));
        }
    }
}
