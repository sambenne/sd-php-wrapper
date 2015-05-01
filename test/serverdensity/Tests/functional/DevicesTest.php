<?php
namespace serverdensity\Tests\functional;

use serverdensity\HttpClient\HttpClient as HttpClient;

/**
* @group functional
*/
class DevicesTest extends TestCase
{

    /**
    * @test
    */
    public function shouldCreateDevice(){
        $device = array(
            "name" => "MyNewDevice",
            "publicIPs" => array("192.161.1.1")
        );

        $createdDevice = $this->client->api('devices')->create($device);


        $this->assertArrayHasKey('_id', $createdDevice);
        $this->assertArrayHasKey('name', $createdDevice);
        $this->assertArrayHasKey('publicIPs', $createdDevice);
        $this->assertEquals(1, count($createdDevice['publicIPs']));

        return $createdDevice;
    }


    /**
    * @test
    * @depends shouldCreateDevice
    */
    public function shouldViewDevice($createdDevice){

        $result = $this->client->api('devices')->view($createdDevice['_id']);

        $this->assertArrayHasKey('_id', $createdDevice);
        $this->assertArrayHasKey('name', $createdDevice);
        $this->assertArrayHasKey('publicIPs', $createdDevice);
        $this->assertEquals($result['_id'], $createdDevice['_id']);
        $this->assertEquals($result['name'], $createdDevice['name']);
        $this->assertEquals($result['publicIPs'], $createdDevice['publicIPs']);
    }

    /**
    * @test
    * @depends shouldCreateDevice
    */
    public function shouldViewAllDevices(){

        $result = $this->client->api('devices')->all();


        $this->assertGreaterThan(0, count($result));
        $this->assertEquals(true, is_array($result[0]));

        $this->assertArrayHasKey('_id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('publicIPs', $result[0]);
    }

    /**
    * @test
    * @depends shouldCreateDevice
    */
    public function shouldSearchDevices(){

        $filter = array(
            "name" => "MyNewDevice"
        );

        $fields = array(
            "_id",
            "name"
        );

        $result = $this->client->api('devices')->search($filter, $fields);


        $this->assertEquals(1, count($result));
        $this->assertEquals(true, is_array($result[0]));

        $this->assertArrayHasKey('_id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayNotHasKey('publicIPs', $result[0]);
    }


    /**
    * @test
    * @depends shouldCreateDevice
    */
    public function shouldUpdateDevices($createdDevice){
        $fields = array(
            'name' => 'AnotherName',
            'publicIPs' => ['0.0.0.0']
        );

        $result = $this->client->api('devices')->update($createdDevice['_id'], $fields);

        $this->assertArrayHasKey('name', $result);
        $this->assertEquals($fields['name'], $result['name']);
        $this->assertArrayHasKey('publicIPs', $result);
        $this->assertEquals($fields['publicIPs'][0], $result['publicIPs'][0]);
    }

    /**
    * @test
    * @depends shouldCreateDevice
    */
    public function shouldDeleteDevices($createdDevice){

        $result = $this->client->api('devices')->delete($createdDevice['_id']);

        $this->assertArrayHasKey('_id', $result);
        $this->assertEquals($createdDevice['_id'], $result['_id']);

    }

    /**
    * @test
    * @depends shouldCreateDevice
    */
    public function shouldFailDeleteDevice($createdDevice){

        $this->setExpectedException('serverdensity\Exception\NotFoundException');
        $result = $this->client->api('devices')->delete($createdDevice['_id']);

    }

}
