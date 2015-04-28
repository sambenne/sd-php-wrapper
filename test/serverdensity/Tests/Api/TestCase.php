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

        $httpClient = $this->getMockBuilder('GuzzleHttp\Client')
            ->setMethods(['send'])
            ->getMock();

        $client = new Client();
        $this->assertInstanceOf('serverdensity\Api\\'.ucwords($class), $client->api($class));

        $mock = $this->getMockBuilder('serverdensity\HttpClient\HttpClient')
            ->disableOriginalConstructor()
            ->SetConstructorArgs([array(), $httpClient])
            ->getMock();

        $client = new \serverdensity\Client($mock);
        $client->setHttpClient($mock);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(array('get', 'post', 'postRaw', 'patch', 'HTTPdelete', 'put'))
            ->setConstructorArgs(array($client))
            ->getMock();
    }
}
