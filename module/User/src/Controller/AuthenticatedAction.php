<?php

namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;

abstract class AuthenticatedAction extends AbstractActionController
{
    use UserFetchable;

    /**
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     */
    public function __construct($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }
}
