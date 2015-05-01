<?php
namespace serverdensity\Tests\functional;

use serverdensity\HttpClient\HttpClient as HttpClient;

/**
* @group functional
*/
class ServicesTest extends TestCase
{

    /**
    * @test
    */
    public function shouldCreateService(){
        $service = array(
            "name" => "MyNewService",
            "checkType" => "http",
            "checkMethod" => "GET",
            "checkUrl" => "http://www.serverdensity.com",
            "timeout" => 10,
            "checkLocations" => ['lon'],
            "slowThreshold" => 100,

        );

        $createdService = $this->client->api('services')->create($service);


        $this->assertArrayHasKey('_id', $createdService);
        $this->assertArrayHasKey('name', $createdService);
        $this->assertArrayHasKey('checkUrl', $createdService);

        $this->assertEquals(1, count($createdService['checkLocations']));

        return $createdService;
    }


    /**
    * @test
    * @depends shouldCreateService
    */
    public function shouldViewService($createdService){

        $result = $this->client->api('services')->view($createdService['_id']);

        $this->assertArrayHasKey('_id', $createdService);
        $this->assertArrayHasKey('name', $createdService);
        $this->assertArrayHasKey('checkLocations', $createdService);
        $this->assertEquals($result['_id'], $createdService['_id']);
        $this->assertEquals($result['name'], $createdService['name']);
        $this->assertEquals($result['checkLocations'], $createdService['checkLocations']);
    }

    /**
    * @test
    * @depends shouldCreateService
    */
    public function shouldViewAllService(){

        $result = $this->client->api('services')->all();


        $this->assertGreaterThan(0, count($result));
        $this->assertEquals(true, is_array($result[0]));

        $this->assertArrayHasKey('_id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('checkLocations', $result[0]);
    }

    /**
    * @test
    * @depends shouldCreateService
    */
    public function shouldSearchService(){

        $filter = array(
            "name" => "MyNewService"
        );

        $fields = array(
            "_id",
            "name"
        );

        $result = $this->client->api('services')->search($filter, $fields);

        $this->assertEquals(1, count($result));
        $this->assertEquals(true, is_array($result[0]));

        $this->assertArrayHasKey('_id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayNotHasKey('checkLocations', $result[0]);
    }


    /**
    * @test
    * @depends shouldCreateService
    */
    public function shouldUpdateService($createdService){
        $fields = array(
            'name' => 'AnotherName',
            'checkLocations' => ['dub']
        );

        $result = $this->client->api('services')->update($createdService['_id'], $fields);

        $this->assertArrayHasKey('name', $result);
        $this->assertEquals($fields['name'], $result['name']);
        $this->assertArrayHasKey('checkLocations', $result);
        $this->assertEquals($fields['checkLocations'], $result['checkLocations']);
    }

    /**
    * @test
    * @depends shouldCreateService
    */
    public function shouldDeleteService($createdService){

        $result = $this->client->api('services')->delete($createdService['_id']);

        $this->assertArrayHasKey('_id', $result);
        $this->assertEquals($createdService['_id'], $result['_id']);

    }



}
