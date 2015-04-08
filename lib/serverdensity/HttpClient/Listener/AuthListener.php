<?php

namespace serverdensity\HttpClient\Listener;

use Guzzle\Common\Event;
use serverdensity\Client;
use serverdensity\Exception\RuntimeException;

class AuthListener
{
    private $tokenOrLogin;
    private $password;
    private $method;

    public function __construct($tokenOrLogin, $password = null, $method)
    {
        $this->tokenOrLogin = $tokenOrLogin;
        $this->password = $password;
        $this->method = $method;
    }

    public function onRequestBeforeSend(Event $event)
    {
        // Skip by default
        if (null === $this->method) {
            return;
        }

        switch ($this->method) {
            case Client::AUTH_URL_TOKEN:
                $url = $event['request']->getUrl();
                $url .= (false === strpos($url, '?') ? '?' : '&');
                $url .= utf8_encode(http_build_query(array('token' => $this->tokenOrLogin), '', '&'));

                $event['request']->setUrl($url);
                break;

            default:
                throw new RuntimeException(sprintf('%s not yet implemented', $this->method));
                break;
        }
    }
}
