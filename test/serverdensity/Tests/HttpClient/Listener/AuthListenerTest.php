<?php

namespace serverdensity\Tests\HttpClient;

use GuzzleHttp\Message\Request;
use serverdensity\Client;
use serverdensity\HttpClient\Listener\AuthListener;

class AuthListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function shouldHaveKnownMethodName()
    {
        $request = $this->getMock('GuzzleHttp\Message\RequestInterface');

        $listener = new AuthListener('test', 'unknown');
        $listener->onRequestBeforeSend($this->getEventMock($request));
    }

    /**
     * @test
     */
    public function shouldDoNothingForHaveNullMethod()
    {
        $request = $this->getMock('GuzzleHttp\Message\RequestInterface');

        $request->expects($this->never())
            ->method('getUrl');

        $listener = new AuthListener('test', null);
        $listener->onRequestBeforeSend($this->getEventMock($request));
    }

    /**
     * @test
     */
    public function shouldSetTokenInUrlForAuthUrlMethod()
    {
        $request = new Request('GET', '/res');

        $listener = new AuthListener('test', Client::AUTH_URL_TOKEN);
        $listener->onRequestBeforeSend($this->getEventMock($request));

        $this->assertEquals('/res?token=test', $request->getUrl());
    }

    private function getEventMock($request = null)
    {
        $mock = $this->getMockBuilder('GuzzleHttp\Event\BeforeEvent')
            ->disableOriginalConstructor()
            ->getMock();

        if ($request) {
            $mock->expects($this->any())
                ->method('getRequest')
                ->will($this->returnValue($request));
        }

        return $mock;
    }
}
