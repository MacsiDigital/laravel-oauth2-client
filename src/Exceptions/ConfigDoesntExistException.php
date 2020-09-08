<?php

namespace MacsiDigital\OAuth2\Exceptions;

class ConfigDoesntExistException extends Base
{
    public function __construct($name)
    {
        parent::__construct('No Config '.$name.' found.');
    }
}
