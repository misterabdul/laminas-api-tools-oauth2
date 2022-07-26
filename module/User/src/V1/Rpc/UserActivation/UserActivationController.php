<?php

namespace User\V1\Rpc\UserActivation;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\ApiProblemResponse;
use Laminas\ApiTools\Hal\View\HalJsonModel;
use Laminas\Json\Json;
use Laminas\Mvc\Controller\AbstractActionController;

class UserActivationController extends AbstractActionController
{
    /**
     * @var \Laminas\InputFilter\InputFilterInterface
     */
    protected $userActivationValidator;

    /**
     * @var \User\V1\Service\UserActivation
     */
    protected $userActivationService;

    /**
     * @param  \Laminas\InputFilter\InputFilterInterface  $userActivationValidator
     * @param  \User\V1\Service\UserActivation  $userActivationService
     */
    public function __construct(
        $userActivationValidator,
        $userActivationService
    ) {
        $this->userActivationValidator = $userActivationValidator;
        $this->userActivationService   = $userActivationService;
    }

    /**
     * @return mixed
     */
    public function activationAction()
    {
        try {
            $this->userActivationValidator
                ->setData(Json::decode($this->getRequest()->getContent(), true));
            $this->userActivationService
                ->activate($this->userActivationValidator->getValues());

            return new HalJsonModel([]);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(
                422,
                "Failed Validation",
                null,
                null,
                ['validation_messages' => ['activationUuid' => [$e->getMessage()]]]
            ));
        }
    }
}
