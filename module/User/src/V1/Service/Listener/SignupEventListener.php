<?php

namespace User\V1\Service\Listener;

use Aqilix\OAuth2\Entity\OauthAccessToken as AccessTokenEntity;
use Aqilix\OAuth2\Entity\OauthClient as ClientEntity;
use Aqilix\OAuth2\Entity\OauthRefreshToken as RefreshTokenEntity;
use Aqilix\OAuth2\Entity\OauthUser as OauthUserEntity;
use Psr\Log\LoggerAwareTrait;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use User\Entity\UserActivation as UserActivationEntity;
use User\Entity\UserProfile as UserProfileEntity;
use User\V1\SignupEvent;

class SignupEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait,
        LoggerAwareTrait;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Aqilix\OAuth2\Mapper\OauthUser
     */
    protected $userMapper;

    /**
     * @var \User\Mapper\UserProfile  $userProfileMapper
     */
    protected $userProfileMapper;

    /**
     * @var \User\Mapper\UserActivation  $userActivationMapper
     */
    protected $userActivationMapper;

    /**
     * @var \Aqilix\OAuth2\Mapper\OauthClient
     */
    protected $clientMapper;

    /**
     * @var \Aqilix\OAuth2\Mapper\OauthAccessToken
     */
    protected $accessTokenMapper;

    /**
     * @var \Aqilix\OAuth2\Mapper\OauthRefreshToken
     */
    protected $refreshTokenMapper;

    /**
     * @var \Aqilix\OAuth2\ResponseType\AccessToken
     */
    protected $oauth2AccessToken;

    /**
     * Constructor
     *
     * @param  \Aqilix\OAuth2\Mapper\OauthUser  $userMapper
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     * @param  \User\Mapper\UserActivation  $userActivationMapper
     * @param  \Aqilix\OAuth2\Mapper\OauthClient  $clientMapper
     * @param  \Aqilix\OAuth2\Mapper\OauthAccessToken  $accessTokenMapper
     * @param  \Aqilix\OAuth2\Mapper\OauthRefreshToken  $refreshTokenMapper
     * @param  \Aqilix\OAuth2\ResponseType\AccessToken  $oauth2AccessToken
     * @param  \Psr\Log\LoggerAwareInterface  $logger
     */
    public function __construct(
        $config,
        $userMapper,
        $userProfileMapper,
        $userActivationMapper,
        $clientMapper,
        $accessTokenMapper,
        $refreshTokenMapper,
        $oauth2AccessToken,
        $logger
    ) {
        $this->config = $config;
        $this->userMapper = $userMapper;
        $this->userProfileMapper = $userProfileMapper;
        $this->userActivationMapper = $userActivationMapper;
        $this->clientMapper = $clientMapper;
        $this->accessTokenMapper = $accessTokenMapper;
        $this->refreshTokenMapper = $refreshTokenMapper;
        $this->oauth2AccessToken = $oauth2AccessToken;
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
            SignupEvent::EVENT_INSERT_USER,
            [$this, 'createUser'],
            499
        );
        $this->listeners[] = $events->attach(
            SignupEvent::EVENT_INSERT_USER,
            [$this, 'createAccessToken'],
            498
        );
        $this->listeners[] = $events->attach(
            SignupEvent::EVENT_INSERT_USER,
            [$this, 'createUserProfile'],
            497
        );
        $this->listeners[] = $events->attach(
            SignupEvent::EVENT_INSERT_USER,
            [$this, 'createActivation'],
            496
        );
    }

    /**
     * Create New User
     *
     * @param  \User\V1\SignupEvent  $event
     * @return void|\Exception
     */
    public function createUser($event)
    {
        try {
            $user = new OauthUserEntity();
            $signupData = $event->getSignupData();
            $password   = $this->userMapper
                ->getPasswordHash($signupData['password']);
            $user->setUsername($signupData['email']);
            $user->setPassword($password);
            $this->userMapper->save($user);
            $event->setUserEntity($user);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username}",
                [
                    "function" => __FUNCTION__,
                    "username" => $signupData['email'],
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    /**
     * Create User Profile
     *
     * @param  \User\V1\SignupEvent  $event
     * @return void|\Exception
     */
    public function createUserProfile($event)
    {
        try {
            $user = $event->getUserEntity();
            $userProfile = new UserProfileEntity();
            $userProfile->setUser($user);
            $this->userMapper->save($userProfile);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username}",
                [
                    "function" => __FUNCTION__,
                    "username" => $user->getUsername(),
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    /**
     * Create Access Token
     *
     * @param  \User\V1\SignupEvent  $event
     * @return void|\Exception
     */
    public function createAccessToken($event)
    {
        try {
            $clientId = $this->config['client_id'];
            $client = $this->clientMapper
                ->fetchOneBy(['clientId' => $clientId]);
            if (!($client instanceof ClientEntity))
                throw new \Exception('Client ID not found.');

            $user = $event->getUserEntity();
            $now = new \DateTime('now');
            $accessTokensExpires = new \DateTime();
            $accessTokensExpires->setTimestamp(
                $now->getTimestamp() + $this->config['expires_in']
            );
            // @todo retrieve expired from config
            $refreshTokenExpires = new \DateTime('now');
            $refreshTokenExpires->add(new \DateInterval('P14D'));

            // insert access_token
            $accessTokens = new AccessTokenEntity();
            $accessTokens->setClient($client)
                ->setAccessToken($this->oauth2AccessToken->generateToken())
                ->setExpires($accessTokensExpires)
                ->setUser($user);
            $this->accessTokenMapper->save($accessTokens);

            // insert refresh_token
            $refreshTokens = new RefreshTokenEntity();
            $refreshTokens->setClient($client)
                ->setRefreshToken($this->oauth2AccessToken->generateToken())
                ->setExpires($refreshTokenExpires)
                ->setUser($user);
            $this->refreshTokenMapper->save($refreshTokens);

            // set accessToken response
            $accessTokensResponse = [
                'access_token'  => $accessTokens->getAccessToken(),
                'expires_in'    => $this->config['expires_in'],
                'token_type'    => $this->config['token_type'],
                'scope'         => $this->config['scope'],
                'refresh_token' => $refreshTokens->getRefreshToken(),
            ];
            $event->setAccessTokenResponse($accessTokensResponse);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username} {accessToken}",
                [
                    "function"      => __FUNCTION__,
                    "username"      => $user->getUsername(),
                    "accessToken"   => $accessTokens->getAccessToken(),
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }

    /**
     * Create Activation
     *
     * @param  \User\V1\SignupEvent  $event
     * @return void|\Exception
     */
    public function createActivation($event)
    {
        try {
            $expiration = new \DateTime();
            // 14 day expiration
            // @todo retrieve expired from config
            $expiration->add(new \DateInterval('P14D'));
            $user = $event->getUserEntity();
            $userActivation = new UserActivationEntity();
            $userActivation->setUser($user);
            $userActivation->setExpiration($expiration);
            $this->userActivationMapper->save($userActivation);
            $event->setUserActivationKey($userActivation->getUuid());
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} {username} {activationUuid}",
                [
                    "function"          => __FUNCTION__,
                    "username"          => $user->getUsername(),
                    "activationUuid"    => $userActivation->getUuid(),
                ]
            );
        } catch (\Exception $e) {
            $event->stopPropagation(true);
            return $e;
        }
    }
}
