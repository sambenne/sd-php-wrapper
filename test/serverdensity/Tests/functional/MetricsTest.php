<?php
namespace serverdensity\Tests\functional;

use serverdensity\HttpClient\HttpClient as HttpClient;
use GuzzleHttp\Exception\RequestException;

/**
* @group functional
*/
class MetricsTest extends TestCase
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
    public function shouldGetAvailableMetrics($device){

        // if you want to test properly give a device that has data that is older
        $result = $this->client->api('metrics')->available($device['_id'], strtotime('-5 hours'), time());

        $this->assertEquals(is_array($result), true);
    }

    /**
    * @test
    * @depends shouldCreateDevice
    */
    public function shouldGetMetrics($device){

        $filter = array(
            'networkTraffic' => array(
                'eth0' => ['rxMByteS']
            )
        );

        // if you want to test properly give a device that has data that is older
        $result = $this->client->api('metrics')->metrics($device['_id'], $filter, strtotime('-5 hours'), time());

        $this->assertEquals(is_array($result), true);
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
}
