<?php

namespace Aqilix\OAuth2\ResponseType;

use OAuth2\Storage\Memory;
use OAuth2\ResponseType\AccessToken as OAuth2AccessToken;

/**
 * @author Dolly Aswin <dolly.aswin@gmail.com>
 *
 * AccessToken Response
 */
class AccessToken extends OAuth2AccessToken
{
    /**
     */
    public function __construct()
    {
        $tokenStorage = new Memory([
            'access_tokens' => [
                'revoke' => ['mytoken'],
            ],
        ]);

        parent::__construct($tokenStorage);
    }

    /**
     * @return string
     */
    public function generateToken()
    {
        return $this->generateAccessToken();
    }
}
