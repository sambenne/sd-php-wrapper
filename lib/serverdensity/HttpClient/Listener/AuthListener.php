<?php

namespace serverdensity\HttpClient\Listener;

use serverdensity\Client;
use serverdensity\Exception\RuntimeException;

use GuzzleHttp\Event\BeforeEvent;

class AuthListener
{
    private $token;
    private $method;

    public function __construct($token, $method)
    {
        $this->token = $token;
        $this->method = $method;
    }

    public function onRequestBeforeSend(BeforeEvent $event)
    {
        // Skip by default
        if (null === $this->method) {
            return;
        }
        $request = $event->getRequest();
        switch ($this->method) {
            case Client::AUTH_URL_TOKEN:
                $url = $event->getRequest()->getUrl();
                $url .= (false === strpos($url, '?') ? '?' : '&');
                $url .= utf8_encode(http_build_query(array('token' => $this->token), '', '&'));
                $event->getRequest()->setUrl($url);
                break;

            default:
                throw new RuntimeException(sprintf('%s not yet implemented', $this->method), $request);
                break;
        }
    }
}
