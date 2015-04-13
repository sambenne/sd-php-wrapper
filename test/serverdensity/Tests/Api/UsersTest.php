<?php

namespace serverdensity\Tests\Api;

class UsersTest extends TestCase
{
    protected function getApiClass()
    {
        return 'serverdensity\Api\User';
    }

    /**
    * @test
    */
    public function shouldGetUser()
    {
        $expectedArray = array('id' => '1', 'username' => 'Joe');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->getUser('1'));
    }
}
