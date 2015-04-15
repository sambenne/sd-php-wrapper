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

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('inventory/tags/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->view('1'));
    }

    /**
    * @test
    */
    public function shouldGetAllTags(){
        $expectedArray = array(
            array('_id' => '1', 'name' => 'myTag'),
            array('_id' => '2', 'name' => 'myTag2')
        );

        $api = $this->getApiMock();
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

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('inventory/tags/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->destroy('1'));

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

        $api = $this->getApiMock();
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

        $api = $this->getApiMock();
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

        $api = $this->getApiMock();
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

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('inventory/tags/1')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('1', $expectedArray));
    }
}


