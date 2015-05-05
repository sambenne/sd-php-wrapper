<?php

namespace serverdensity\Tests\HttpClient;

use serverdensity\HttpClient\Listener\ErrorListener;

class ErrorListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldPassIfResponseNotHaveErrorStatus()
    {
        $response = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $response->expects($this->exactly(2))
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @expectedException \serverdensity\Exception\ApiLimitExceedException
     */
    public function shouldFailWhenApiLimitWasExceed()
    {
        $response = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $response->expects($this->exactly(2))
            ->method('getStatusCode')
            ->will($this->returnValue(429));

        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(0));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @expectedException \serverdensity\Exception\NotFoundException
     */
    public function shouldNotPassWhenContentWasValidJsonButStatusIsNotCovered()
    {
        //$this->setExpectedException('serverdensity\Exception\NotFoundException');

        $response = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->setConstructorArgs([404])
            //->disableOriginalConstructor()
            ->getMock();

        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(404));

        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));

        $response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue(json_encode(array('message' => 'test'))));

        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(404));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @expectedException \serverdensity\Exception\RuntimeException
     */
    public function shouldNotPassWhen400IsSent()
    {
        $response = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue(json_encode(array('message' => 'test'))));
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(400));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    /**
     * @test
     * @dataProvider getErrorCodesProvider
     * @expectedException \serverdensity\Exception\ValidationFailedException
     */
    public function shouldNotPassWhen400IsSentWithErrorCode($errorCode)
    {
        $content = json_encode(array(
            'message' => 'Validation Failed',
            'errors'  => array(
                array(
                    'type'     => $errorCode,
                    'description'    => 'This went wrong',
                    'param'    => 'login'
                )
            )
        ));

        $response = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();
        $response->expects($this->once())
            ->method('getHeader')
            ->with('X-RateLimit-Remaining')
            ->will($this->returnValue(5000));
        $response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));
        $response->expects($this->any())
            ->method('getStatusCode')
            ->will($this->returnValue(400));

        $listener = new ErrorListener(array('api_limit' => 5000));
        $listener->onRequestError($this->getEventMock($response));
    }

    public function getErrorCodesProvider()
    {
        return array(
            array('missing_param'),
            array('duplicate_param'),
            array('invalid_param'),
        );
    }

    private function getEventMock($response)
    {
        $eventMock = $this->getMockBuilder('GuzzleHttp\Event\ErrorEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $request = $this->getMockBuilder('GuzzleHttp\Message\Request')
            ->disableOriginalConstructor()
            ->getMock();

        // $response = $this->getMockBuilder('GuzzleHttp\Message\Response')
        //     ->disableOriginalConstructor()
        //     ->getMock();

        $eventMock->expects($this->any())
            ->method('hasResponse')
            ->will($this->returnValue(true));

        $eventMock->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($request));

        $eventMock->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($response));

        return $eventMock;
    }

}
