<?php

namespace serverdensity\Tests\Api;

class UsersTest extends TestCase
{
    protected function getApiClass()
    {
        return 'serverdensity\Api\Users';
    }

    /**
    * @test
    */
    public function shouldGetUser()
    {
        $expectedArray = array('_id' => '1', 'username' => 'Joe');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/users/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->view('1'));
    }

    /**
    * @test
    */
    public function shouldGetAllUsers(){
        $expectedArray = array(
            array('_id' => '1', 'username' => 'Joe'),
            array('_id' => '2', 'username' => 'Joe2')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('users/users/')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
    * @test
    */
    public function shouldDeleteUser(){
        $expectedArray = array('_id' => '1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('users/users/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->destroy('1'));
    }

    /**
    * @test
    */
    public function shouldCreateUser(){
        $expectedArray = array(
            '_id' => '1',
            'username' => 'Joe'
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('users/users/')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create($expectedArray));
    }

    /**
    * @test
    */
    public function shouldUpdateUser(){
        $expectedArray = array('_id' => '1', 'username' => 'Joe');
        $input = array('username' => 'Joe');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('users/users/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('1', $input));
    }
}
