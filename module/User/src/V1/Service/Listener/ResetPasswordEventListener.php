<?php

namespace User\V1\Service\Listener;

use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Psr\Log\LoggerAwareTrait;
use User\V1\ResetPasswordEvent;

class ResetPasswordEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait,
        LoggerAwareTrait;

    /**
     * @var \User\Mapper\ResetPassword
     */
    protected $resetPasswordMapper;

    /**
     * @var \Aqilix\OAuth2\Mapper\OauthUser
     */
    protected $userMapper;

    /**
     * Constructor
     *
     * @param  \Aqilix\Oauth2\Mapper\OauthUser  $userMapper
     * @param  \User\Mapper\ResetPassword  $resetPasswordMapper
     * @param  \Psr\Log\LoggerAwareInterface  $logger
     */
    public function __construct(
        $userMapper,
        $resetPasswordMapper,
        $logger
    ) {
        $this->userMapper = $userMapper;
        $this->resetPasswordMapper = $resetPasswordMapper;
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
            ResetPasswordEvent::EVENT_RESET_PASSWORD_CONFIRM_EMAIL,
            [$this, 'create'],
            499
        );
        $this->listeners[] = $events->attach(
            ResetPasswordEvent::EVENT_RESET_PASSWORD_CONFIRM_EMAIL_SUCCESS,
            [$this, 'setResetPasswordKey'],
            500
        );
        $this->listeners[] = $events->attach(
            ResetPasswordEvent::EVENT_RESET_PASSWORD_RESET,
            [$this, 'resetPassword'],
            499
        );
    }

    /**
     * Create Reset Password
     *
     * @param  \User\V1\ResetPasswordEvent  $event
     * @return \Exception|void
     */
    public function create($event)
    {
        // @todo retrieve expired from config
        $expiration = new \DateTime();
        $expiration->add(new \DateInterval('P14D'));
        try {
            $resetPassword = new \User\Entity\ResetPassword;
            $resetPassword->setUser($event->getUserEntity());
            $resetPassword->setExpiration($expiration);
            $this->resetPasswordMapper->save($resetPassword);
            $event->setResetPasswordEntity($resetPassword);
            // set reset password key
            $event->setResetPasswordKey($resetPassword->getUuid());
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username} {key}",
                [
                    "function" => ResetPasswordEvent::EVENT_RESET_PASSWORD_CONFIRM_EMAIL,
                    "username" => $event->getUserEntity()->getUsername(),
                    "key" => $resetPassword->getUuid()
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    /**
     * Set Reset Password Key
     *
     * @param  \User\V1\ResetPasswordEvent  $event
     * @return void
     */
    public function setResetPasswordKey($event)
    {
        $resetPassword = $event->getResetPasswordEntity();
        if (!is_null($resetPassword)) {
            $event->setResetPasswordKey($resetPassword->getUuid());
        }
    }

    /**
     * Reset Password
     *
     * @param  \User\V1\ResetPasswordEvent  $event
     * @return void
     */
    public function resetPassword($event)
    {
        $resetPasswordData = $event->getResetPasswordData();
        $resetPassword = $event->getResetPasswordEntity();
        $user = $event->getUserEntity();
        $password = $this->userMapper
            ->getPasswordHash($resetPasswordData['newPassword']);
        $user->setPassword($password);
        $resetPassword->setPassword($password);
        $resetPassword->setReseted(new \DateTime());
        $this->userMapper->save($user);
        $this->resetPasswordMapper->save($resetPassword);
        $event->setUserEntity($user);
        $event->setResetPasswordEntity($resetPassword);
        $this->logger->log(
            \Psr\Log\LogLevel::INFO,
            "{function} {username}",
            [
                "function" => __FUNCTION__,
                "username" => $user->getUsername()
            ]
        );
    }
}
