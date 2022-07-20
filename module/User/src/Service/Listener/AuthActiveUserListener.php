<?php

namespace User\Service\Listener;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\ApiProblem\ApiProblemResponse;
use Laminas\ApiTools\MvcAuth\Identity\GuestIdentity;
use Laminas\Mvc\MvcEvent;

class AuthActiveUserListener
{
    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     */
    public function __construct($userProfileMapper)
    {
        $this->userProfileMapper = $userProfileMapper;
    }

    /**
     * Check activated
     *
     * @param  \Laminas\ApiTools\MvcAuth\MvcAuthEvent  $ev
     * @return mixed
     */
    public function __invoke($ev)
    {
        $identity = $ev->getIdentity();
        if ($identity instanceof GuestIdentity) {
            return;
        }

        $username = $identity->getAuthenticationIdentity();
        if (!is_string($username)) {
            return;
        }

        $userProfile = $this->userProfileMapper
            ->fetchOneByOauthUsername($username);
        if (!$userProfile->getIsActive()) {
            $response = new ApiProblemResponse(
                new ApiProblem(
                    401,
                    "Your account has not yet been activated. "
                        . "We have sent an email to " . $username . " "
                        . "Please check your inbox and click on the activation link "
                        . "to continue registration. If you do not see the email "
                        . "please check your Spam/Junk folder just in case"
                )
            );

            $mvcEvent = $ev->getMvcEvent();
            /**
             * @var \Laminas\Http\Response
             */
            $mvcResponse = $mvcEvent->getResponse();
            $mvcResponse->setStatusCode($response->getStatusCode());
            $mvcResponse->setHeaders($response->getHeaders());
            $mvcResponse->setContent($response->getContent());
            $mvcResponse->setReasonPhrase('Unauthorized');

            $em = $mvcEvent->getApplication()->getEventManager();
            $mvcEvent->setName(MvcEvent::EVENT_FINISH);
            $em->triggerEvent($mvcEvent);
            $ev->stopPropagation();

            return $mvcResponse;
        }

        return;
    }
}
