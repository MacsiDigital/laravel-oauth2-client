<?php

namespace MacsiDigital\OAuth2\Support;

class AuthorisationProcessor
{
    public function __construct($accessToken, $integration)
    {
        $config = config($integration);
        $token = $config['tokenModel'];

        return (new $token($integration))->updateAccessToken($accessToken);
    }
}
