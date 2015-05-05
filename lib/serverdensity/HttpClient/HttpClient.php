<?php

namespace serverdensity\HttpClient;

use serverdensity\Exception\TwoFactorAuthenticationRequiredException;
use serverdensity\Exception\ErrorException;
use serverdensity\Exception\RuntimeException;
use serverdensity\HttpClient\Listener\AuthListener;
use serverdensity\HttpClient\Listener\ErrorListener;

use GuzzleHttp\Event\HasEmitterTrait;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\ErrorEvent;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use ReflectionClass;


/**
 * Performs requests on Server Density API. API documentation should be self-explanatory.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class HttpClient implements HttpClientInterface
{

    protected $options = array(
        'base_url'    => 'https://api.serverdensity.io/',
        'defaults'    => [
            'headers' => ['user-agent' => 'SD-php-api']],

        'timeout'     => 10,
        // 'api_limit'   => 5000,
        // 'api_version' => 'v2',
    );

    protected $headers = array();

    private $lastResponse;
    private $lastRequest;
    public $client;

    /**
     * @param array           $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = array(), ClientInterface $client = null)
    {
        $this->options = array_merge($this->options, $options);
        $client = $client ?: new GuzzleClient($this->options);
        $this->client  = $client;
        $options = $this->options;

        $this->client->getEmitter()->on(
            'error', function (ErrorEvent $event) use ($options){
                $listener = new ErrorListener($this->options);
                $listener->onRequestError($event);
        });

        // $this->clearHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Clears used headers.
     */
    public function clearHeaders()
    {
        // $this->headers = array(
        //     'Accept' => sprintf('application/vnd.github.%s+json', $this->options['api_version']),
        //     'User-Agent' => sprintf('%s', $this->options['defaults']['headers']['user-agent']),
        // );
    }

    public function addListener($eventName, $listener)
    {
        $emitter = $this->client->getEmitter();
        $emitter->on($eventName, $listener);
        // $this->client->getEventDispatcher()->addListener($eventName, $listener);
    }

    // public function addSubscriber(EventSubscriberInterface $subscriber)
    // {
    //     $this->client->addSubscriber($subscriber);
    // }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, null, 'GET', $headers, array('query' => $parameters));
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, $body = null, array $headers = array())
    {
        return $this->request($path, $body, 'POST', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, $body = null, array $headers = array())
    {
        return $this->request($path, $body, 'PATCH', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, $body = null, array $headers = array())
    {
        return $this->request($path, $body, 'DELETE', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, $body, array $headers = array())
    {
        return $this->request($path, $body, 'PUT', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array())
    {
        if(!empty($body)){
            $options = array_merge($options, ['body' => $body]);
        }

        if(!empty($headers)){
            $options = array_merge($options, ['headers' => $headers]);
        }

        $request = $this->client->createRequest($httpMethod, $path, $options);

        // Errors handled in ErrorListener.php
        $response = $this->client->send($request);

        $this->lastRequest  = $request;
        $this->lastResponse = $response;

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate($token, $method)
    {
        $this->client->getEmitter()->on(
            'before', function (BeforeEvent $event) use ($token, $method){
                $auth = new AuthListener($token, $method);
                $auth->onRequestBeforeSend($event);
            });
    }

    /**
     * @return Request
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return Response
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

}
