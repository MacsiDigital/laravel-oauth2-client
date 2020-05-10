<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use MacsiDigital\Oauth2\Integration;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Integration::class, function (Faker $faker) {
    return [
    	'accessToken' => '',
        'refreshToken' => '',
        'expires' => '',
        'additional' => '',
    ];
});
