<?php

/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace User\OAuth2\Factory;

use Laminas\ApiTools\OAuth2\Controller\Exception\RuntimeException;
use Laminas\ApiTools\OAuth2\Factory\PdoAdapterFactory as LaminasPdoAdapterFactory;
use User\OAuth2\Adapter\PdoAdapter;

/**
 * Override PDOAdapterFactory
 *
 * @author dolly
 *
 */
class PdoAdapterFactory extends LaminasPdoAdapterFactory
{
    /**
     * @param  \Psr\Container\ContainerInterface  $container
     * @return \User\Oauth2\Adapter\PdoAdapter
     */
    public function __invoke($container)
    {
        $config = $container->get('config');
        if (empty($config['api-tools-oauth2']['db']))
            throw new RuntimeException('The database configuration [\'api-tools-oauth2\'][\'db\'] for OAuth2 is missing');

        $connection = [
            'dsn'       => $config['api-tools-oauth2']['db']['dsn'] ?? null,
            'username'  => $config['api-tools-oauth2']['db']['username'] ?? null,
            'password'  => $config['api-tools-oauth2']['db']['password'] ?? null,
            'options'   => $config['api-tools-oauth2']['db']['options'] ?? [],
        ];
        $oauth2ServerConfig = $config['api-tools-oauth2']['storage_settings'] ?? [];

        return new PdoAdapter(
            $connection,
            $oauth2ServerConfig
        );
    }
}
