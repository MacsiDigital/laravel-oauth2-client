<?php

Route::get('oauth2/{integration}/authorise', 'MacsiDigital\OAuth2\Http\Controllers\AuthorisationController@create')->name('authorise');

// add American authorize route
Route::get('oauth2/{integration}/authorize', 'MacsiDigital\OAuth2\Http\Controllers\AuthorisationController@create')->name('authorize');

Route::get('oauth2/{integration}/callback', 'MacsiDigital\OAuth2\Http\Controllers\AuthorisationController@store')->name('callback');
