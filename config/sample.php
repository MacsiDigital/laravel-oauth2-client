<?php

return [
	'oauth2' => [
		'clientId' => '',
		'clientSecret' => '',
	],
	'options' => [
		'scope' => ['openid email profile offline_access accounting.settings accounting.transactions accounting.contacts accounting.journals.read accounting.reports.read accounting.attachments']
	],
	'tokenProcessor' => '\MacsiDigital\OAuth2\Support\AuthorisationProcessor',
	'tokenModel' => '\MacsiDigital\OAuth2\Support\FileToken',
	'authorisedRedirect' => '',
	'failedRedirect' => '',
];
