<?php
namespace serverdensity\Tests\functional;

use Guzzle\Http\Client as GuzzleClient;
use GuzzleHttp\Client as NewGuzzle;
use GuzzleHttp\Exception\ClientException as NewExec;
use Guzzle\Http\Exception\ClientErrorResponseException;

/**
* @group functional
*/
class UserTest extends TestCase
{
    /**
    * @test
    */
    public function test(){
        //codehere...
    }


    // /**
    // * @test
    // */
    // public function shouldCreateUser(){
    //     $user = array(
    //         "admin" => true,
    //         "firstName" => "Llama",
    //         "lastName" => "Hat",
    //         "login" => "llama",
    //         "password" => "password",
    //         "emailAddresses" => array(
    //             "llama@gmail.com"
    //         ),
    //         "phoneNumbers" => array(
    //             "+342351412"
    //         )
    //     );

    //     $createdUser = $this->client->api('users')->create($user);
    //     $this->assertArrayHasKey('_id', $createdUser);
    //     $this->assertArrayHasKey('firstName', $createdUser);
    //     $this->assertArrayHasKey('lastName', $createdUser);
    //     $this->assertArrayHasKey('phoneNumbers', $createdUser);

    //     echo $createdUser;

    //     return $createdUser;
    // }

    // /**
    // * @test
    // */
    // public function testGuzzle(){
    //     $token = '5eefa2ed1f30d4f3d704100a591fbf73';
    //     $baseUrl = 'https://api.serverdensity.io';
    //     $url = '/users/users?token=';
    //     $client = new NewGuzzle();

    //     $request = $client->get($url.$token);
    //     $response = $request->send();
    //     // echo $response;

    //     // url- form urlencoded ok.
    // }

    // /**
    // * @test
    // */
    // public function postGuzzle()
    // {

    //     $token = '';
    //     $baseUrl = 'https://api.serverdensity.io/users/users?token=5eefa2ed1f30d4f3d704100a591fbf73';
    //     $httpbin = 'http://httpbin.org/post';
    //     $url = '';

    //     $user = [
    //         'body' => [
    //             'login' => 'Llama',
    //             'firstName' => 'Hat',
    //             'lastName' => 'llama',
    //             'password' => 'password'
    //         ]
    //     ];

    //     $client = new GuzzleClient();
    //     try {
    //         $req = $client->post($baseUrl, array(), $user);
    //         $response2 = $client->send($req);
    //     } catch ( ClientErrorResponseException $e){
    //         echo $e->getResponse();
    //     }
    //     echo $response2;

    // }

    // /**
    // * @test
    // */
    // public function postGuzzle()
    // {

    //     $token = '';
    //     $baseUrl = 'https://api.serverdensity.io/users/users?token=5eefa2ed1f30d4f3d704100a591fbf73';
    //     $httpbin = 'http://httpbin.org/post';
    //     $url = '';

    //     $user = [
    //         'body' => [
    //             'login' => 'Llama',
    //             'firstName' => 'Hat',
    //             'lastName' => 'llama',
    //             'password' => 'password'
    //         ]
    //     ];

    //     $client = new NewGuzzle();
    //     try {
    //         $response = $client->post($baseUrl, $user);
    //     } catch ( ClientException $e){
    //         echo $e->getResponse();
    //         echo $response->getBody();
    //     }

    // }

    // /**
    // * @test
    // */
    // public function shouldGetUser(){
    //     $user = $this->client->api('users')->view('548999b995fe3506532d991f');
    //     $this->assertArrayHasKey('_id', $user);
    // }
}
