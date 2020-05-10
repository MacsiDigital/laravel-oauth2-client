<?php
namespace MacsiDigital\OAuth2\Support\Token;

use MacsiDigital\OAuth2\Support\Token\Base;

class DB extends Base
{
	protected $model;

	public function __construct($integration)
	{
		$this->model = Integration::where('name', $integration)->firstOrNew();
		$this->set($this->model);
		return $this;
	}

	public function set($config) 
	{
		$this->setAccessToken($config->accessToken);
		$this->setRereshToken($config->refreshToken);
		$this->setExpires($config->expires);
		foreach($config->additional as $key => $item){
			$this->key = $item;
		}
		return $this;
	}

	public function save() 
	{
		$this->model->accessToken = $this->accessToken();
		$this->model->refreshToken = $this->refreshToken();
		$this->model->expires = $this->expires();
		$this->model->save();
		return $this;
	}

}