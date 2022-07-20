<?php

namespace User\V1\Service\Listener;

use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Psr\Log\LoggerAwareTrait;
use User\V1\UserActivationEvent;

class UserActivationEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait,
        LoggerAwareTrait;

    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * @var \User\Mapper\UserActivation
     */
    protected $userActivationMapper;

    /**
     * Construct
     *
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     * @param  \User\Mapper\UserActivation  $userActivationMapper
     * @param  \Psr\Log\LoggerAwareInterface  $logger
     */
    public function __construct(
        $userProfileMapper,
        $userActivationMapper,
        $logger
    ) {
        $this->userProfileMapper = $userProfileMapper;
        $this->userActivationMapper = $userActivationMapper;
        $this->logger = $logger;
    }

    /**
     * @param  \Laminas\EventManager\EventManagerInterface  $events
     * @param  int  $priority
     * @return void
     */
    public function attach($events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            UserActivationEvent::EVENT_ACTIVATE_USER,
            [$this, 'isExpired'],
            499
        );
        $this->listeners[] = $events->attach(
            UserActivationEvent::EVENT_ACTIVATE_USER,
            [$this, 'isActivated'],
            495
        );
        $this->listeners[] = $events->attach(
            UserActivationEvent::EVENT_ACTIVATE_USER,
            [$this, 'activate'],
            490
        );
    }

    /**
     * Check activated
     *
     * @param  \User\V1\UserActivationEvent  $event
     * @return \RuntimeException|void
     */
    public function isActivated($event)
    {
        $userActivation = $event->getUserActivationEntity();
        if ($userActivation->getActivated() !== null) {
            $event->stopPropagation(true);
            return new \RuntimeException('Activation UUID has been activated');
        }
    }

    /**
     * Check expiration
     *
     * @param  \User\V1\UserActivationEvent  $event
     * @return \RuntimeException|void
     */
    public function isExpired($event)
    {
        $now = new \DateTime();
        $userActivation = $event->getUserActivationEntity();
        if ($userActivation->getExpiration() < $now) {
            $event->stopPropagation(true);
            return new \RuntimeException('User Activation UUID has expired');
        }
    }

    /**
     * Activate New User
     *
     * @param  \User\V1\UserActivationEvent  $event
     * @return \Exception|void
     */
    public function activate($event)
    {
        $userActivation = $event->getUserActivationEntity();
        $userProfile = $event->getUserProfileEntity();
        try {
            $userProfile->setIsActive(true);
            $userProfile->setUserActivation($userActivation);
            $userActivation->setActivated(new \DateTime('now'));
            $this->userProfileMapper->save($userProfile);
            $this->userActivationMapper->save($userActivation);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username} {activationUuid}",
                [
                    "function" => __FUNCTION__,
                    "username" => $userActivation->getUser()->getUsername(),
                    "activationUuid" => $userActivation->getUuid()
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }
}
