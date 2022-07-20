<?php

namespace User\V1\Service\Listener;

use Aqilix\Image\Resizer as ImageResizer;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\InputFilter\Exception\InvalidArgumentException;
use Laminas\InputFilter\InputFilterInterface;
use Psr\Log\LoggerAwareTrait;
use User\V1\ProfileEvent;

class ProfileEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait,
        LoggerAwareTrait;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * @var \Laminas\Hydrator\HydrationInterface
     */
    protected $userProfileHydrator;

    /**
     * Constructor
     *
     * @param  array  $config
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     * @param  \Laminas\Hydrator\HydratorInterface  $userProfileHydrator
     * @param  \Psr\Log\LoggerAwareInterface  $logger
     */
    public function __construct(
        $config,
        $userProfileMapper,
        $userProfileHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->userProfileMapper = $userProfileMapper;
        $this->userProfileHydrator = $userProfileHydrator;
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
            ProfileEvent::EVENT_UPDATE_PROFILE,
            [$this, 'updateProfile'],
            499
        );
        $this->listeners[] = $events->attach(
            ProfileEvent::EVENT_UPDATE_PROFILE,
            [$this, 'resizeProfilePhoto'],
            498
        );
    }

    /**
     * Resize Profile Photo
     *
     * @param  \User\V1\ProfileEvent  $event
     * @return \RuntimeException|void
     */
    public function resizeProfilePhoto($event)
    {
        $userProfileEntity = $event->getUserProfileEntity();
        $updateData = $event->getUpdateData();
        if (is_null($updateData["photo"])) {
            return;
        }

        if (!ImageResizer::save($updateData["photo"]["tmp_name"], $updateData["photo"]["tmp_name"])) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {username} {filename}",
                [
                    "function" => __FUNCTION__,
                    "username" => $userProfileEntity->getUser()->getUsername(),
                    "filename" => $updateData["photo"]["tmp_name"]
                ]
            );
            $event->stopPropagation(true);
            return new \RuntimeException("Cannot resize profile photo");
        }

        $this->logger->log(
            \Psr\Log\LogLevel::INFO,
            "{function} {username} {filename}",
            [
                "function" => __FUNCTION__,
                "username" => $userProfileEntity->getUser()->getUsername(),
                "filename" => $updateData["photo"]["tmp_name"]
            ]
        );
    }

    /**
     * Update Profile
     *
     * @param  \User\V1\ProfileEvent  $event
     * @return \Exception|void
     * @throws \Laminas\InputFilter\Exception\InvalidArgumentException
     */
    public function updateProfile(ProfileEvent $event)
    {
        try {
            $userProfileEntity = $event->getUserProfileEntity();
            $currentPhoto = $event->getUserProfileEntity()->getPhoto();
            $updateData   = $event->getUpdateData();
            // add file input filter here
            if (!$event->getInputFilter() instanceof InputFilterInterface) {
                throw new InvalidArgumentException('Input Filter not set');
            }

            if (!is_null($updateData["photo"])) {
                // adding filter for photo
                $inputPhoto  = $event->getInputFilter()->get('photo');
                $inputPhoto->getFilterChain()
                    ->attach(new \Laminas\Filter\File\RenameUpload([
                        'target' => $this->config['backup_dir'],
                        'randomize' => true,
                        'use_upload_extension' => true
                    ]));
                $userProfile = $this->userProfileHydrator
                    ->hydrate($updateData, $userProfileEntity);
            } else {
                // avoid empty photo uploaded override existing photo
                $userProfile = $this->userProfileHydrator
                    ->hydrate($updateData, $userProfileEntity);
                $userProfile->setPhoto($currentPhoto);
            }

            $this->userProfileMapper->save($userProfile);
            $event->setUserProfileEntity($userProfile);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username}",
                [
                    "function" => __FUNCTION__,
                    "username" => $userProfileEntity->getUser()->getUsername()
                ]
            );
        } catch (\Exception $e) {
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} {username} {error}",
                [
                    "function" => __FUNCTION__,
                    "username" => $userProfileEntity->getUser()->getUsername(),
                    "error" => $e->getMessage()
                ]
            );
            $event->stopPropagation(true);
            return $e;
        }
    }
}
