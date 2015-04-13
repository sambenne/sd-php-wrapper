<?php

namespace serverdensity;

use serverdensity\Exception\InvalidArgumentException;
use serverdensity\Exception\BadMethodCallException;
use serverdensity\HttpClient\HttpClient;
use serverdensity\HttpClient\HttpClientInterface;

class Client
{
    const AUTH_URL_TOKEN = 'token';


    /**
     * The Buzz instance used to communicate with Server Density.
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Instantiate a new Server Density client.
     *
     * @param null|HttpClientInterface $httpClient Server Density http client
     */
    public function __construct(HttpClientInterface $httpClient = null) {
        $this->httpClient = $httpClient;
    }

    private $options = array(
        'timeout' => 10
    );

    public function api($name) {
        switch($name){
            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
    }

    /**
     * Authenticate a user for all next requests.
     *
     * @param string      $token        serverdensity private token
     * @param null|string $authMethod   One of the AUTH_URL_TOKEN class constants
     *
     * @throws InvalidArgumentException If no authentication method was given
     */
    public function authenticate($token, $authMethod = null)
    {
        if ($token === null) {
            throw InvalidArgumentException('You need to specify a token');
        }

        if ($authMethod === null) {
            $authMethod = self::AUTH_URL_TOKEN;
        }

        $this->getHttpClient()->authenticate($token, $authMethod);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if ($this->httpClient === null) {
            $this->httpClient = new HttpClient();
        }

        return $this->httpClient;
    }

    public function setHttpClient(HttpClientInterface $httpClient){
        $this->httpClient = $httpClient;
    }

    public function setHeaders(array $headers)
    {
        $this->getHttpClient()->setHeaders($headers);
    }

    public function clearHeaders()
    {
        $this->getHttpClient()->clearHeaders();
    }

    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            if (!array_key_exists($name, $this->getHttpClient()->options)){
                throw new InvalidArgumentException(sprintf('Undefined option called: "%s"', $name));
            } else {
                return $this->getHttpClient()->options[$name];
            }
        } else {
            return $this->options[$name];
        }
    }

    public function __call($name, $args)
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }



}

?>
