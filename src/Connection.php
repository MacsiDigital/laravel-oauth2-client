<?php
namespace MacsiDigital\OAuth2;

use MacsiDigital\OAuth2\Contracts\Connection as ConnectionContract;
use MacsiDigital\OAuth2\Support\Providers\GenericProvider;
use MacsiDigital\OAuth2\Traits\ForwardsCalls;

class Connection implements ConnectionContract
{
    use ForwardsCalls;

    protected $provider;
    protected $options;

    /**
     * Return if the OAuth2 implementation is authenticated.
     *
     * @param  string  $integration
     * @return bool
     *
     */
    public function authenticated($integration)
    {
        $config = config($integration);
        $token = new $config['tokenModel']($integration);

        return $token->authenticated();
    }

    /**
     * Set connection options.
     *
     * @param  array  $options
     * @return self
     *
     */
    public function withOptions($options)
    {
        $this->options = $options;
        $this->provider = new GenericProvider($options);

        return $this;
    }

    /**
     * Handle dynamic method calls into the model. Forward calls to the provider
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->provider, $method, $parameters);
    }
}
