<?php
namespace MacsiDigital\OAuth2\Contracts;

interface Token
{
    public function set($options);

    public function accessToken();

    public function setAccessToken($token);

    public function refreshToken();

    public function setRefreshToken($token);

    public function expires();

    public function setExpires($timeStamp);

    public function hasExpired();

    public function save();
}
