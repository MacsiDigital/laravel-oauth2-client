<?php
namespace MacsiDigital\OAuth2\Support\Token;

use MacsiDigital\OAuth2\Support\Token\Base;

class File extends Base
{
	protected $disk;

	public function __construct($integration)
	{
		$config = include('/storage/app/oauth2/'.$integration);
		$this->set($config);
		$this->integration = $integration;
		$this->disk = Storage::disk('local');
		return $this;
	}

	public function save() 
	{
		if(!$this->disk->exists('oauth2')){
			$this->disk->makeDirectory('oauth2');
		}
		$this->disk('local')->put('/oauth2/'.$integration.'.php', $this->generateContent());
		return $this;
	}

	public function generateContent()
	{
		return "<?php 
		[
			'accessToken' => '".$this->accessToken."',
			'refreshToken' => '".$this->refreshToken."',
			'expires' => '".$this->expires."',
		];";
	}

}