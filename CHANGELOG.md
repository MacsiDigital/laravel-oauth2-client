# Changelog

All notable changes to `laravel-oauth2-client` will be documented in this file

## 2.0.1 - 2022-09-15

In some cases the token check and API call can run over 1 second apart which can cause issues if the token check is at the token expiry time, as the API call fails due to an expired token.

This fixes the issue by renewing the token if there is less than 1 minute of expiry on the token.

## 2.0.0 - 2022-03-31

Support PHP8.1 and Laravel 9

## 1.1.0 - 2020-09-08

- Initial Release with Laravel 8.0

## 1.0.0 - 2020-05-10

- New OAuth2 Client Authenticaiton Library Alpha
