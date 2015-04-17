<?php

namespace serverdensity\Tests\Api;

class DevicesTest extends TestCase
{
    protected function getApiClass()
    {
        return 'serverdensity\Api\Devices';
    }

    /**
    * @test
    */
    public function shouldCreateUser(){
        $expectedArray = array(
            '_id' => '1',
            'name' => 'myDevice'
        );

        $api = $this->getApiMock('devices');
        $api->expects($this->once())
            ->method('post')
            ->with('inventory/devices/')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create($expectedArray));
    }

    /**
    * @test
    */
    public function shouldDeleteDevice(){
        $expectedArray = array('_id' => '1', 'name' => 'myDevice');

        $api = $this->getApiMock('devices');
        $api->expects($this->once())
            ->method('delete')
            ->with('inventory/devices/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->destroy('1'));

    }

    /**
    * @test
    */
    public function shouldGetAllTags(){
        $expectedArray = array(
            array('_id' => '1', 'name' => 'myDevice'),
            array('_id' => '2', 'name' => 'myDevice2')
        );

        $api = $this->getApiMock('devices');
        $api->expects($this->once())
            ->method('get')
            ->with('inventory/devices/')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }


    /**
    * @test
    */
    public function shouldFindDevices(){
        $expectedArray = array(
            array('_id' => '1', 'name' => 'myDevice'),
            array('_id' => '2', 'name' => 'myDevice')
        );

        $filter = array(
            'filter' => array(
                'name' => 'myDevice',
                'type' => 'device'
            )
        );

        $fields = array(
            array(
                'name',
                '_id'
            )
        );

        $expectedParam = array(
            'filter' => json_encode($filter),
            'fields' => json_encode($fields)
        );

        $api = $this->getApiMock('devices');
        $api->expects($this->once())
            ->method('get')
            ->with('inventory/resources/', $expectedParam)
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->search($filter, $fields));
    }

    /**
    * @test
    */
    public function shouldUpdateDevice(){
        $expectedArray = array('_id' => '1', 'name' => 'myDevice');

        $api = $this->getApiMock('devices');

        $api->expects($this->once())
            ->method('put')
            ->with('inventory/devices/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('1'));
    }

    /**
    * @test
    */
    public function shouldViewDeviceByAgentKey(){
        $expectedArray = array('_id' => '1', 'name' => 'myDevice');

        $agentKey = 'AGENTKEY';

        $api = $this->getApiMock('devices');
        $api->expects($this->once())
            ->method('get')
            ->with('inventory/devices/'.$agentKey.'/byagentkey/')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->viewByAgent($agentKey));
    }



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
