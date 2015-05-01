<?php
namespace serverdensity\Tests\functional;

use serverdensity\HttpClient\HttpClient as HttpClient;

/**
* @group functional
*/
class TagsTest extends TestCase
{

    /**
    * @test
    */
    public function shouldCreateTags(){
        $tags = "MyNewTag1";

        $createdTags = $this->client->api('tags')->create($tags);


        $this->assertArrayHasKey('_id', $createdTags);
        $this->assertArrayHasKey('name', $createdTags);
        $this->assertArrayHasKey('color', $createdTags);

        return $createdTags;
    }


    /**
    * @test
    * @depends shouldCreateTags
    */
    public function shouldViewDevice($createdTags){

        $result = $this->client->api('tags')->view($createdTags['_id']);

        $this->assertArrayHasKey('_id', $createdTags);
        $this->assertArrayHasKey('name', $createdTags);
        $this->assertEquals($result['_id'], $createdTags['_id']);
        $this->assertEquals($result['name'], $createdTags['name']);
    }

    /**
    * @test
    * @depends shouldCreateTags
    */
    public function shouldViewAllTags(){

        $result = $this->client->api('tags')->all();


        $this->assertGreaterThan(0, count($result));
        $this->assertEquals(true, is_array($result[0]));

        $this->assertArrayHasKey('_id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
    }


    /**
    * @test
    * @depends shouldCreateTags
    */
    public function shouldUpdateTags($createdTags){
        $fields = array(
            'name' => 'AnotherName',
        );

        $result = $this->client->api('tags')->update($createdTags['_id'], $fields);

        $this->assertArrayHasKey('name', $result);
        $this->assertEquals($fields['name'], $result['name']);
    }

    /**
    * @test
    * @depends shouldCreateTags
    */
    public function shouldDeleteTags($createdTags){

        $result = $this->client->api('tags')->delete($createdTags['_id']);

        $this->assertArrayHasKey('_id', $result);
        $this->assertEquals($createdTags['_id'], $result['_id']);

    }

}
