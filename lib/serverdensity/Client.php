<?php

namespace serverdensity;

use serverdensity\InvalidArgumentException;
use serverdensity\HttpClient;
use serverdensity\HttpClientInterface;

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
        $this->httpClient = $httClient;
    }

    private $options = array(
        'timeout' => 10
    );

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

        $this->getHttpClient()->authenticate($token, $authmethod);
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

    public getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            if (!array_key_exists($name, $this->getHttpClient()->options))
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
