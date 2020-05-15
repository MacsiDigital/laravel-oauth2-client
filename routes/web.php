<?php

Route::middleware(['web'])->group(function () {
	Route::get('oauth2/{integration}/authorise', 'MacsiDigital\OAuth2\Http\Controllers\AuthorisationController@create')->name('oauth2.authorise');

	// add American authorize route
	Route::get('oauth2/{integration}/authorize', 'MacsiDigital\OAuth2\Http\Controllers\AuthorisationController@create')->name('oauth2.authorize');

	Route::get('oauth2/{integration}/callback', 'MacsiDigital\OAuth2\Http\Controllers\AuthorisationController@store')->name('oauth2.callback');
});