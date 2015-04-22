<?php

namespace serverdensity\Api;

use serverdensity\Client;
use serverdensity\HttpClient\Message\ResponseMediator;


abstract class AbstractApi {

    /**
    * @var Client
    */
    protected $client;

    /**
    * @param Client $client
    */
    public function __construct(Client $client){
        $this->client = $client;
    }

    /**
    * @param string $path           Request path
    * @param array $parameters      GET parameters
    * @param array $requestHeaders  Request Headers
    *
    * @return \Guzzle\Http\EntityBodyInterface|mixed|string
    */
    protected function get($path, array $parameters = array(), array $requestHeaders = array()){
        $response = $this->client->getHttpClient()->get($path, $parameters, $requestHeaders);

        return ResponseMediator::getContent($response);
    }

    /**
    * @param string $path           Request path
    * @param array $parameters      POST parameters to be JSON encoded.
    * @param array $requestHeaders  Request headers
    *
    * @return result of postRaw
    */
    protected function post($path, array $parameters = array(), $requestHeaders = array()){
        return $this->postRaw(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );
    }

    /**
    * @param string $path           Request path
    * @param string $body           Request body
    * @param array $requestHeaders  Request headers
    *
    * @return \Guzzle\Http\EntityBodyInterface|mixed|string
    */
    protected function postRaw($path, $body, $requestHeaders = array()){
        $response = $this->client->getHttpClient()->post(
            $path,
            $body,
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
    * Send a PATCH request with JSON-encoded parameters
    *
    * @param string $path           Request path
    * @param array $parameters      POST parameters to be JSON encoded.
    * @param array $requestHeaders  request headers.
    */
    protected function patch($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->patch(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
    * Send a PUt request with JSON encoded parameters
    * @param string $path           Request path
    * @param array $parameters      POST parameters to be json encoded
    * @param array $requestHeaders  Request headers
    */
    protected function put($path, array $parameters = array(), $requestHeaders = array()){
        $response = $this->client->getHttpClient()->put(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
    * Send a DELETE request with Json encoded parameters
    * @param string $path           Request path
    * @param array  $parameters     POST parameters to be json encoded
    * @param array  $requestHeaders Request headers
    */
    protected function HTTPdelete($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->client->getHttpClient()->delete(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );

        return ResponseMediator::getContent($response);
    }

    /**
    * If a value contains an array json encode that value
    * @param array  $array  checking the following array
    */
    protected function makeJsonReady($array)
    {
        foreach($array as $key => $val){
            if (is_array($val)){
                $array[$key] = json_encode($val);
            }
        }
        return $array;
    }
}
