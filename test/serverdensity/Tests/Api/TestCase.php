<?php

namespace serverdensity\Tests\Api;

use serverdensity\Client;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    abstract protected function getApiClass();

    /**
    * @param    string  the class used by ApiMock
    * @throws   InvalidArgumentException when class is doesn't exist
    */
    protected function getApiMock($class)
    {
        $httpClient = $this->getMock('Guzzle\Http\Client', array('send'));
        $httpClient
            ->expects($this->any())
            ->method('send');

        $client = new Client();
        $this->assertInstanceOf('serverdensity\Api\\'.ucwords($class), $client->api($class));

        $mock = $this->getMock('serverdensity\HttpClient\HttpClient', array(), array(array(), $httpClient));

        $client = new \serverdensity\Client($mock);
        $client->setHttpClient($mock);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(array('get', 'post', 'postRaw', 'patch', 'delete', 'put'))
            ->setConstructorArgs(array($client))
            ->getMock();
    }
}
