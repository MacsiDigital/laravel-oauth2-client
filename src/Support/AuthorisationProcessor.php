<?php

namespace MacsiDigital\OAuth2\Support;

class AuthorisationProcessor
{
	public function __invoke($accessToken)
    {
    	$token = $config['tokenStore'];
        return (new $token([
        	'accessToken' => $accessToken->getToken(),
        	'refreshToken' => $accessToken->getRefreshToken(),
        	'expires' => $accessToken->getExpires()
        ]))->save();
    }

}