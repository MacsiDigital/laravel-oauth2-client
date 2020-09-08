<?php

namespace MacsiDigital\OAuth2\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cookie;
use MacsiDigital\OAuth2\Contracts\Connection;
use MacsiDigital\OAuth2\Exceptions\AlreadyAuthenticatedException;
use MacsiDigital\OAuth2\Exceptions\ConfigDoesntExistException;
use MacsiDigital\OAuth2\Exceptions\IdentityProviderException;
use MacsiDigital\OAuth2\Http\Requests\OAuth2Validation;

class AuthorisationController extends BaseController
{
    use ValidatesRequests;

    public function create(Connection $connection, $integration)
    {
        // Are we already authenticated?
        if ($connection->authenticated($integration)) {
            throw new AlreadyAuthenticatedException($integration);
        }
        // If not then we need to ask for a token
        $config = config($integration);

        if ($config == []) {
            throw new ConfigDoesntExistException($integration);
        }

        $connection->withOptions(array_merge(['redirectUri' => route('oauth2.callback', ['integration' => $integration])], $config['oauth2']));

        $url = $connection->getAuthorizationUrl($config['options']);

        Cookie::queue(Cookie::make('oauth2state', $connection->getState(), 10));

        return redirect()->away($url);
    }

    public function store(OAuth2Validation $request, Connection $connection, $integration)
    {
        // Are we already authenticated?
        if ($connection->authenticated($integration)) {
            throw new AlreadyAuthenticatedException($integration);
        }

        // If not then to prcess the token and save the access token
        $config = config($integration);
        if ($config == []) {
            throw new ConfigDoesntExistException($integration);
        }

        $connection->withOptions(array_merge(['redirectUri' => route('oauth2.callback', ['integration' => $integration])], $config['oauth2']));

        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $connection->getAccessToken('authorization_code', [
                'code' => $request->code,
            ]);

            $token = new $config['tokenProcessor']($accessToken, $integration);
            
            Cookie::forget('oauth2state');

            return redirect($config['authorisedRedirect']);
        } catch (IdentityProviderException $e) {
            return redirect($config['failedRedirect'], ['error' => $e->getMessage()]);
        }
    }
}
