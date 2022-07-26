<?php

namespace User\V1\Rpc\Me;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\ApiProblemResponse;
use Laminas\ApiTools\Hal\View\HalJsonModel;
use User\Controller\AuthenticatedAction;

class MeController extends AuthenticatedAction
{
    /**
     * @var \Doctrine\Laminas\Hydrator\DoctrineObject
     */
    protected $userProfileHydrator;

    /**
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     * @param  \Doctrine\Laminas\Hydrator\DoctrineObject  $userProfileHydrator
     */
    public function __construct(
        $userProfileMapper,
        $userProfileHydrator
    ) {
        parent::__construct($userProfileMapper);
        $this->userProfileHydrator = $userProfileHydrator;
    }

    /**
     * @return mixed
     */
    public function meAction()
    {
        $me = $this->fetchUserProfile();
        if ($me === null)
            return new ApiProblemResponse(new ApiProblem(401, "Unauthenticated"));

        $extracted = $this->userProfileHydrator
            ->extract($me);

        return new HalJsonModel($extracted);
    }
}
