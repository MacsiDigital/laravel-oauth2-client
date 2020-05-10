<?php
namespace MacsiDigital\OAuth2;

use MacsiDigital\OAuth2\Traits\ForwardsCalls;
use \League\OAuth2\Client\Provider\GenericProvider;
use MacsiDigital\OAuth2\Contracts\Provider as ProviderContract;

class Provider implements ProviderContract
{
	use ForwardsCalls;

    protected $provider;
	protected $options;

	public function withOptions($options)
	{
        $this->options = $options;
    //    $this->provider = new GenericProvider($options);
        return $this;
	}

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }
        
        return $this->forwardCallTo($this->provider, $method, $parameters);
    }

}