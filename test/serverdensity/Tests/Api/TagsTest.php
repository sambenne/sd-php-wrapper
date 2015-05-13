<?php

namespace serverdensity\Tests\Api;

class TagsTest extends TestCase
{
    protected function getApiClass()
    {
        return 'serverdensity\Api\Tags';
    }

    /**
    * @test
    */
    public function shouldGetTag(){
        $expectedArray = array('_id' => '1', 'name' => 'myTag');

        $api = $this->getApiMock('tags');
        $api->expects($this->once())
            ->method('get')
            ->with('inventory/tags/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->view('1'));
    }

    /**
    * @test
    */
    public function testFormat(){
        $tags = array(
            [
                '_id' => '123123123',
                'name' => 'tag1',
                'color' => 'f0f0f0'
            ],
            [
                '_id' => '121212',
                'name' => 'tag2',
                'color' => 'f1f1f1'
            ]
        );

        $expectedUserFormat = array(
            'tags' => [
                ['123123123' => 'readWrite'],
                ['121212' => 'readWrite']
            ]
        );

        $expectedOtherFormat = array(
            'tags' => [
                '123123123',
                '121212'
            ]
        );

        $api = $this->getApiMock('tags');
        $userFormatted = $api->format($tags, 'user');
        $otherFormatted = $api->format($tags, 'other');
        $this->assertEquals($expectedUserFormat, $userFormatted);
        $this->assertEquals($expectedOtherFormat, $otherFormatted);
    }

    /**
    * @test
    */
    public function shouldGetAllTags(){
        $expectedArray = array(
            array('_id' => '1', 'name' => 'myTag'),
            array('_id' => '2', 'name' => 'myTag2')
        );

        $api = $this->getApiMock('tags');
        $api->expects($this->once())
            ->method('get')
            ->with('inventory/tags/')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
    * @test
    */
    public function shouldDeleteTag(){
        $expectedArray = array('_id' => '1', 'name' => 'myTag');

        $api = $this->getApiMock('tags');
        $api->expects($this->once())
            ->method('HTTPdelete')
            ->with('inventory/tags/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->delete('1'));

    }


    /**
    * @test
    */
    public function shouldFindTag(){
        $expectedArray = array(
            array('_id' => '1', 'name' => 'myTag'),
            array('_id' => '2', 'name' => 'tag2')
        );

        $found = array('_id' => '1', 'name' => 'myTag');

        $api = $this->getApiMock('tags');
        $api->expects($this->once())
            ->method('get')
            ->with('inventory/tags/')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($found, $api->find('myTag'));

    }

    /**
    * @test
    */
    public function DontFindTagReturnWithEmptyArray(){
        $expectedArray = array(
            array('_id' => '1', 'name' => 'myTag'),
            array('_id' => '2', 'name' => 'tag2')
        );

        $emptyArray = array();

        $api = $this->getApiMock('tags');
        $api->expects($this->once())
            ->method('get')
            ->with('inventory/tags/')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($emptyArray, $api->find('notExisting'));

    }

    /**
    * @test
    */
    public function shouldCreateTag(){
        $expectedArray = array('_id' => '1', 'name' => 'myTag');

        $api = $this->getApiMock('tags');
        $api->expects($this->once())
            ->method('post')
            ->with('inventory/tags/')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create($expectedArray));
    }

    /**
    * @test
    */
    public function shouldUpdateTag(){
        $expectedArray = array('_id' => '1', 'name' => 'newName');
        $update = array('name' => 'newName');

        $api = $this->getApiMock('tags');
        $api->expects($this->once())
            ->method('put')
            ->with('inventory/tags/1', $update)
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('1', $update));
    }
}


