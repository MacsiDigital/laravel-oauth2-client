<?php

return [
	'oauth2' => [
		'client_id' => '',
		'client_secret' => '',
	],
	'tokenProcessor' => '\MacsiDigital\OAuth2\Support\AuthorisationProcessor',
	'tokenStore' => '\MacsiDigital\OAuth2\Support\FileToken',
	'authorisedRedirect' => '',
	'failedRedirect' => '', 
];