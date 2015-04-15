<?php

namespace serverdensity\Tests\Api;

class DevicesTest extends TestCase
{
    protected function getApiClass()
    {
        return 'serverdensity\Api\Devices';
    }

    // /**
    // * @test
    // */
    // public function shouldCreateUser(){
    //     $expectedArray = array(
    //         '_id' => '1',
    //         'name' => 'myDevice'
    //     );

    //     $api = $this->getApiMock();
    //     $api->expects($this->once())
    //         ->method('post')
    //         ->with('inventory/devices/')
    //         ->will($this->returnValue($expectedArray));

    //     $this->assertEquals($expectedArray, $api->create($expectedArray));
    // }


    /**
    * @test
    */
    public function shouldGetDevice(){
        $expectedArray = array('_id' => '1', 'name' => 'myDevice');

        $api = $this->getApiMock('devices');

        $api->expects($this->once())
            ->method('get')
            ->with('inventory/devices/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->view('1'));
    }
}
