# Laravel OAuth2 Client

## Laravel package for OAuth 2 Client Authentication

![Header Image](https://github.com/MacsiDigital/repo-design/raw/master/laravel-oauth2-client/header.png)

<p align="center">
 <a href="https://github.com/MacsiDigital/laravel-oauth2-client/actions?query=workflow%3ATests"><img src="https://github.com/MacsiDigital/laravel-oauth2-client/workflows/Tests/badge.svg" style="max-width:100%;"  alt="tests badge"></a>
 <a href="https://packagist.org/packages/macsidigital/laravel-oauth2-client"><img src="https://img.shields.io/packagist/v/macsidigital/laravel-oauth2-client.svg?style=flat-square" alt="version badge"/></a>
 <a href="https://packagist.org/packages/macsidigital/laravel-oauth2-client"><img src="https://img.shields.io/packagist/dt/macsidigital/laravel-oauth2-client.svg?style=flat-square" alt="downloads badge"/></a>
</p>

A little OAuth2 Client Authentication Library

## Support us

We invest a lot in creating [open source packages](https://macsidigital.co.uk/open-source), and would be grateful for a [sponsor](https://github.com/sponsors/MacsiDigital) if you make money from your product that uses them.

## Installation

You can install the package via composer:

```bash
composer require macsidigital/laravel-oauth2-client
```

## Package helper

The package helper can be used to return the package version

## Usage

The main aim of this library is to handle the authentication requirements of OAuth2.  Then you should have a token which you can use in an API client.

There are Token Drivers for both File and Database.

### File

The file driver will save a file in storage/app/oauth2, which will keep the token details required to communicate with the OAuth2 Server.


### Database

#### Config

If you want to use the DB driver and would like to customise teh table name then you can publish the config file and amend the table_name column

``` bash
php artisan vendor:publish --provider="MacsiDigital\OAuth2\Providers\OAuth2ServiceProvider" --tag="integration-config"
```

#### Migrations

If using DB driver you will need to publish migrations.

``` bash
php artisan vendor:publish --provider="MacsiDigital\OAuth2\Providers\OAuth2ServiceProvider" --tag="integration-migrations"
```

Then you will need to run migrations

``` bash
php artisan migrate
```

### Integration Configuration

The majority of the setup can be found in the config file, which needs to be copied and placed in the laravel config directory

``` php
return [
	'oauth2' => [
		'clientId' => '',
		'clientSecret' => '',
	],
	'options' => [
		'scope' => ['openid email profile offline_access accounting.settings accounting.transactions accounting.contacts accounting.journals.read accounting.reports.read accounting.attachments']
	],
	'tokenProcessor' => '\MacsiDigital\OAuth2\Support\AuthorisationProcessor',
	'tokenModel' => '\MacsiDigital\OAuth2\Support\Token\File',
	'authorisedRedirect' => '',
	'failedRedirect' => '',
];
```

(Todo: Create a command to automatically publish the config file) 

As the primary focus of the library is in packages, this needs to be loaded into laravel with an integration name through a service provider. So for xero:-

``` php
$this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'xero');
```

You also need to check the credential requirements for the oauth2 server and add to config as required.

## Authorising & the AuthorisationProcessor

There are routes pre-defined to connect to the Oauth2 server, the named routes are 'oauth2.authorise' & 'oauth2.callback' and both need passing in the integration.  So for xero:-

``` php
route('oauth2.authorise', ['integration' => 'xero']); // will return /oauth2/xero/authorise
```

If you are using a simple straight forward Server and if all setup is done correctly we should be linking the account in no time.

However, some API's will have custom processing requirements, for example Xero needs a tenant id.

In these cases we need to create a custom AuthorisationProcessor, which is passed the League/Oauth2-client AccessToken and the integration name so that the config can be pulled.

So this is how it would look for Xero:-

``` php
<?php

namespace MacsiDigital\Xero\Support;

use MacsiDigital\Xero\Facades\Identity;
use MacsiDigital\Xero\Identity\Connection;
use MacsiDigital\Xero\Exceptions\CantRetreiveTenantException;

class AuthorisationProcessor
{
	public function __construct($accessToken, $integration)
    {
    	$config = config($integration);
    
    	$token = $config['tokenModel'];

    	$token = (new $token($integration))->set([
        	'accessToken' => $accessToken->getToken(),
        	'refreshToken' => $accessToken->getRefreshToken(),
        	'expires' => $accessToken->getExpires(),
        	'idToken' => $accessToken->getValues()['id_token']
        ])->save();

    	$connection = Identity::connection()->raw()->get();
    	
    	if($connection != []){
    		$tenantId = $connection->json()[0]['tenantId'];
	        
	        $token->set(['tenantId' => $tenantId])->save();

	        return $token;
    	} else{
    		throw new CantRetreiveTenantException;
    	}
       
    }

}
```

Now our access token etc are saved we should be able to use the macsidigital/laravel-api-client to communicate with OAuth2 API's, of course each API will be different so you need to check documentation.  Here is an example of how we would use the stored details to communicate with Xero API.

``` php
<?php

namespace MacsiDigital\Xero\Support;

use MacsiDigital\Xero\Facades\Client;
use MacsiDigital\API\Support\Entry as ApiEntry;

class Entry extends ApiEntry
{

    public function newRequest()
    {   
    	$config = config('xero');
    	$class = $config['tokenModel'];
    	$token = new $class('xero');
    	if($token->hasExpired()){
    		$token = $token->renewToken();
    	}
        return Client::baseUrl($config['baseUrl'])->withToken($token->accessToken())->withHeaders(['xero-tenant-id' => $token->tenantId()]);
    }

}
```

## Testing

``` bash
composer test
```

## ToDo

- Tests
- Some proper documentation

Basically we are just defining how we can authorise and communicate with the API. For more details on what this means check the documentation for laravel-api-client.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email [info@macsi.co.uk](mailto:info@macsi.co.uk) instead of using the issue tracker.

## Credits

- [Colin Hall](https://github.com/colinhall17)
- [MacsiDigital](https://github.com/MacsiDigital)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
