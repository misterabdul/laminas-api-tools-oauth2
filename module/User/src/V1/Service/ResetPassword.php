<?php

namespace User\V1\Service;

use Laminas\EventManager\EventManagerAwareTrait;
use User\V1\ResetPasswordEvent;

class ResetPassword
{
    use EventManagerAwareTrait;

    /**
     * @var \Aqilix\OAuth2\Mapper\OauthUser
     */
    protected $userMapper;

    /**
     * @var \User\Mapper\ResetPassword
     */
    protected $resetPasswordMapper;

    /**
     * @param  \Aqilix\Oauth2\Mapper\OauthUse  $userMapper
     * @param  \User\Mapper\ResetPassword  $resetPasswordMapper
     */
    public function __construct(
        $userMapper,
        $resetPasswordMapper
    ) {
        $this->userMapper = $userMapper;
        $this->resetPasswordMapper = $resetPasswordMapper;
    }

    /**
     * Create Reset Password
     *
     * @param  array  $confirmEmailData
     * @return \User\Entity\ResetPassword
     */
    public function create($confirmEmailData)
    {
        $emailAddress = $confirmEmailData['emailAddress'];
        $user = $this->userMapper->fetchOneBy(['username' => $emailAddress]);
        if (is_null($user)) {
            throw new \RuntimeException('Email Address not found');
        }

        $event = new ResetPasswordEvent();
        $event->setName(ResetPasswordEvent::EVENT_RESET_PASSWORD_CONFIRM_EMAIL);
        $event->setUserEntity($user);
        $confirmEmail = $this->getEventManager()->triggerEvent($event);
        if ($confirmEmail->stopped()) {
            $event->setException($confirmEmail->last());
            $event->setName(ResetPasswordEvent::EVENT_RESET_PASSWORD_CONFIRM_EMAIL_ERROR);
            $confirmEmail = $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ResetPasswordEvent::EVENT_RESET_PASSWORD_CONFIRM_EMAIL_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
        }
    }

    /**
     * Reset Password User
     *
     * @param  array  $resetData
     * @return void
     * @throws \RuntimeException
     */
    public function reset($resetData)
    {
        $resetPasswordKey = $resetData['resetPasswordKey'];
        try {
            $resetPasswordEntity = $this->getResetPassword($resetPasswordKey);
        } catch (\RuntimeException $e) {
            throw $e;
        }

        $event = new ResetPasswordEvent();
        $event->setName(ResetPasswordEvent::EVENT_RESET_PASSWORD_RESET);
        $event->setUserEntity($resetPasswordEntity->getUser());
        $event->setResetPasswordEntity($resetPasswordEntity);
        $event->setResetPasswordData($resetData);
        $resetPassword = $this->getEventManager()->triggerEvent($event);
        if ($resetPassword->stopped()) {
            $event->setException($resetPassword->last());
            $event->setName(ResetPasswordEvent::EVENT_RESET_PASSWORD_RESET_ERROR);
            $resetPassword = $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ResetPasswordEvent::EVENT_RESET_PASSWORD_RESET_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
        }
    }

    /**
     * Get Reset Password Object
     *
     * @param   string  $resetPasswordKey
     * @return \User\Entity\ResetPassword
     * @throws \RuntimeException
     */
    public function getResetPassword($resetPasswordKey)
    {
        $resetPassword = $this->resetPasswordMapper
            ->fetchOneBy(['uuid' => $resetPasswordKey]);
        if (is_null($resetPassword)) {
            throw new \RuntimeException('Invalid Reset Password Key');
        }

        return $resetPassword;
    }
}
