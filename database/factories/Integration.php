<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use MacsiDigital\Oauth2\Integration;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Integration::class, function (Faker $faker) {
    return [
    	'accessToken' => Str::random('100'),
        'refreshToken' => Str::random('20'),
        'expires' => Str::random('10'),
        'additional' => '',
    ];
});
