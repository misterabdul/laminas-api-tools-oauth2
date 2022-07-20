<?php

namespace User\V1\Notification\Email\Listener;

use User\V1\ResetPasswordEvent;

class ResetPasswordEventListener extends Listener
{
    /**
     * @param  \Laminas\EventManager\EventManagerInterface  $events
     * @param  int  $priority
     * @return void
     */
    public function attach($events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            ResetPasswordEvent::EVENT_RESET_PASSWORD_CONFIRM_EMAIL_SUCCESS,
            [$this, 'sendResetPasswordKey'],
            400
        );
    }

    /**
     * Rund Console to Send Activation Email
     *
     * @param  \User\V1\ResetPasswordEvent  $event
     */
    public function sendResetPasswordKey($event)
    {
        $emailAddress = $event->getUserEntity()->getUsername();
        $resetPasswordKey = $event->getResetPasswordKey();
        // command: laminas-cli user:send-resetpassword-email <emailAddress> <resetPaswordKey>
        $cli = $this->phpProcess
            ->setArguments(['user:send-resetpassword-email', $emailAddress, $resetPasswordKey])
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
