<?php

namespace serverdensity\Tests\HttpClient;

use Guzzle\Http\Message\Request;
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
        $listener = new AuthListener('test', null, 'unknown');
        $listener->onRequestBeforeSend($this->getEventMock());
    }

    /**
     * @test
     */
    public function shouldDoNothingForHaveNullMethod()
    {
        $request = $this->getMock('Guzzle\Http\Message\RequestInterface');
        $request->expects($this->never())
            ->method('addHeader');
        $request->expects($this->never())
            ->method('fromUrl');
        $request->expects($this->never())
            ->method('getUrl');

        $listener = new AuthListener('test', 'pass', null);
        $listener->onRequestBeforeSend($this->getEventMock($request));
    }

    /**
     * @test
     */
    public function shouldSetTokenInUrlForAuthUrlMethod()
    {
        $request = new Request('GET', '/res');

        $listener = new AuthListener('test', null, Client::AUTH_URL_TOKEN);
        $listener->onRequestBeforeSend($this->getEventMock($request));

        $this->assertEquals('/res?token=test', $request->getUrl());
    }

    private function getEventMock($request = null)
    {
        $mock = $this->getMockBuilder('Guzzle\Common\Event')->getMock();

        if ($request) {
            $mock->expects($this->any())
                ->method('offsetGet')
                ->will($this->returnValue($request));
        }

        return $mock;
    }
}
