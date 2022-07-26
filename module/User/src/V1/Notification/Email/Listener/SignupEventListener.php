<?php

namespace User\V1\Notification\Email\Listener;

use User\V1\SignupEvent;

class SignupEventListener extends Listener
{
    /**
     * @param  \Laminas\EventManager\EventManagerInterface  $events
     * @param  int  $priority
     * @return void
     */
    public function attach($events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            SignupEvent::EVENT_INSERT_USER_SUCCESS,
            [$this, 'sendWelcomeEmail'],
            499
        );
    }

    /**
     * Run Console to Send Activation Email
     *
     * @param  \User\V1\SignupEvent  $event
     * @return void
     */
    public function sendWelcomeEmail($event)
    {
        $emailAddress = $event->getUserEntity()->getUsername();
        $userActivationKey = $event->getUserActivationKey();
        // command: laminas-cli user:send-welcome-email <emailAddress> <activationCode>
        $cli = $this->phpProcessBuilder
            ->setArguments(['v1', 'user', 'send-welcome-email', $emailAddress, $userActivationKey])
            ->getProcess();
        $cli->start();
        $pid = $cli->getPid();

        $this->logger->log(
            \Psr\Log\LogLevel::DEBUG,
            "{function} {pid} {commandline}",
            [
                "function" => __FUNCTION__,
                "commandline" => $cli->getCommandLine(),
                "pid" => $pid
            ]
        );
    }
}
