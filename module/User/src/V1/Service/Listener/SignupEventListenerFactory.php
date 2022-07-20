<?php

namespace User\V1\Service\Listener;

use Laminas\ServiceManager\Factory\FactoryInterface;

class SignupEventListenerFactory implements FactoryInterface
{
    /**
     * @param  \Psr\Container\ContainerInterface  $container
     * @param  string  $requestedName
     * @param  array|null  $options
     * @return object
     * @throws \Laminas\ServiceManager\Exception\ServiceNotFoundException If unable to resolve the service.
     * @throws \Laminas\ServiceManager\Exception\ServiceNotCreatedException If an exception is raised when creating a service.
     * @throws \Psr\Container\ContainerExceptionInterface If any other error occurs.
     */
    public function __invoke($container, $requestedName, $options = null)
    {
        $config = $container->get('Config');
        $signupEventConfig = [
            'expires_in' => $config['api-tools-oauth2']['access_lifetime'],
            'client_id'  => 'testclient',
            'token_type' => 'Bearer',
            'scope' => null
        ];
        $userMapper = $container->get(\Aqilix\OAuth2\Mapper\OauthUser::class);
        $userProfileMapper = $container->get(\User\Mapper\UserProfile::class);
        $userActivationMapper = $container->get(\User\Mapper\UserActivation::class);
        $clientMapper = $container->get(\Aqilix\OAuth2\Mapper\OauthClient::class);
        $accessTokensMapper = $container->get(\Aqilix\OAuth2\Mapper\OauthAccessToken::class);
        $refreshTokensMapper = $container->get(\Aqilix\OAuth2\Mapper\OauthRefreshToken::class);
        $oauth2AccessToken = $container->get('oauth2.accessToken');
        $logger = $container->get("logger_default");

        return new SignupEventListener(
            $signupEventConfig,
            $userMapper,
            $userProfileMapper,
            $userActivationMapper,
            $clientMapper,
            $accessTokensMapper,
            $refreshTokensMapper,
            $oauth2AccessToken,
            $logger
        );
    }
}
