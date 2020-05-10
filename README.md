# Laravel package for OAuth 2 Client Authentication

A little OAuth2 Client Authentication Library

## Installation

You can install the package via composer:

```bash
composer require macsidigital/laravel-oauth2-client
```

## Usage

The main aim of this library is to handle the authentication requirements of OAuth2.  Then you should have a token which you can use in a API client.

There are Token Drivers for both File and Database.

### File

The file driver will save a file in storage/app/oauth2, which will keep the token details required to communicate with the OAuth2 Server.

### Database

If using DB you will need to publish migrations.

``` bash
php artisan vendor:publish --provider="MacsiDigital\OAuth2\Providers\OAuth2ServiceProvider" --tag="integration-migrations"
```

Then you will need to run migrations

``` bash
php artisan migrate
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email colin@macsi.co.uk instead of using the issue tracker.

## Credits

- [Colin Hall](https://github.com/macsidigital)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
