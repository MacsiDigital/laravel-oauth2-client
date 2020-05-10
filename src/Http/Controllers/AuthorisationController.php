<?php

namespace MacsiDigital\OAuth2\Http\Controllers;

use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MacsiDigital\OAuth2\Contracts\Provider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use MacsiDigital\OAuth2\Http\Requests\OAuth2Validation;
use MacsiDigital\OAuth2\Exceptions\IdentityProviderException;
use MacsiDigital\OAuth2\Exceptions\ConfigDoesntExistException;

class AuthorisationController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public function create(Provider $provider, $integration) 
    {
        // Are we already authenticated? we will look for the saved credentials file
        if(Storage::disk('local')->exists('/oauth2/'.$intgration.'.php')){
            return redirect()->back();
        }
        // If not then we need to ask for a token
        $config = config($integration);
        if($config == []){
            throw new ConfigDoesntExistException($integration);
        }

        $provider->withOptions(array_merge(['redirectUri' => route('authorise', ['provider' => $provider])], $config['oauth2']));

        $authorisationUrl = $provider->getAuthorizationUrl($config['scopes']);

        session()->flash('oauth2state', $provider->getState());

        return redirect()->away($url);
    }

    public function store(OAuth2Validation $request, Provider $provider, $integration) 
    {

        // Are we already authenticated? we will look for the saved credentials file
        if(Storage::disk('local')->exists('/oauth2/'.$intgration.'.php')){
            return redirect()->back();
        }
        // If not then we need to ask for a token
        $config = config($integration);
        if($config == []){
            throw new ConfigDoesntExistException($integration);
        }

        $provider->withOptions(array_merge(['redirectUri' => route('authorise', ['provider' => $provider])], $config['oauth2']));

        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->code
            ]);
            
            $token = new $config['tokenProcessor'];

            return redirect($config['authorisedRedirect']);
        } catch (IdentityProviderException $e) {
            return redirect($config['failedRedirect'], ['error' => $e->getMessage()]);
        }
    }
}
