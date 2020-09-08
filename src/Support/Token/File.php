<?php
namespace MacsiDigital\OAuth2\Support\Token;

use Illuminate\Support\Facades\Storage;

class File extends Base
{
    protected $disk;

    public function __construct($integration)
    {
        if (Storage::disk('local')->exists('oauth2/'.$integration.'.php')) {
            $config = include(storage_path('app/oauth2/').$integration.'.php');
        } else {
            $config = [];
        }
        $this->set($config);
        $this->integration = $integration;
        $this->disk = Storage::disk('local');

        return $this;
    }

    public function save()
    {
        if (! $this->disk->exists('oauth2')) {
            $this->disk->makeDirectory('oauth2');
        }
        $this->disk->put('/oauth2/'.$this->integration.'.php', $this->generateContent());

        return $this;
    }

    public function delete()
    {
        $this->disk->delete('/oauth2/'.$this->integration.'.php');
    }

    public function generateContent()
    {
        return "<?php 
		return [
			'accessToken' => '".$this->accessToken."',
			'refreshToken' => '".$this->refreshToken."',
			'expires' => '".$this->expires."',
		];";
    }
}
