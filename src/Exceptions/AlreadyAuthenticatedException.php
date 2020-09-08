<?php

namespace MacsiDigital\OAuth2\Exceptions;

class AlreadyAuthenticatedException extends Base
{
    public function __construct($name)
    {
        parent::__construct($name.' already authorised.');
    }
}
