<?php

namespace User\Controller;

use Laminas\ApiTools\Rest\AbstractResourceListener;

abstract class AuthenticatedResource extends AbstractResourceListener
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
