<?php

namespace MacsiDigital\OAuth2\Facades;

use Illuminate\Support\Facades\Facade;

class Package extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'oauth2';
    }
}
