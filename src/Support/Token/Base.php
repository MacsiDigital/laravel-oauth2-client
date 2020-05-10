<?php
namespace MacsiDigital\OAuth2\Support\Token;

use MacsiDigital\Contracts\OAuth2\Token;

abstract class Base implements Token
{

	protected $accessToken;
	protected $refreshToken;
	protected $expires;
	protected $integration;

	public function set($options){
		foreach($options as $key => $item)
		{
			$this->$key = $item;
		}
		return $this;
	}

	public function setAccessToken($token)
	{
		$this->accessToken = $token;
		return $this;
	}

	public function accessToken() 
	{
		return $this->accessToken();
	}

	public function setRefreshToken($token)
	{
		$this->refreshToken = $token;
		return $this;
	}

	public function refreshToken() 
	{
		return $this->refreshToken();
	}

	public function setExpires($timeStamp)
	{
		$this->expires = $timeStamp;
		return $this;
	}

	public function expires() 
	{
		return $this->expires();
	}

	public function hasExpired() 
	{
		return time() > $this->expires;
	}

}