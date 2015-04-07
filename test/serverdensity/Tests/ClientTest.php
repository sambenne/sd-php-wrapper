<?php

namespace serverdensity\Tests;

use serverdensity\Client;
use serverdensity\Exception\InvalidArgumentException;
use serverdensity\Exception\BadMethodCallException;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf('serverdensity\HttpClient\HttpClient', $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldPassHttpClientInterfaceToConstructor()
    {
        $client = new Client($this->getHttpClientMock());

        $this->assertInstanceOf('serverdensity\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    /**
     * @test
     * @dataProvider getAuthenticationFullData
     */
    public function shouldAuthenticateUsingAllGivenParameters($login, $password, $method)
    {
        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('authenticate')
            ->with($login, $password, $method);

        $client = new Client($httpClient);
        $client->authenticate($login, $password, $method);
    }

    public function getAuthenticationFullData()
    {
        return array(
            array('login', 'password', Client::AUTH_HTTP_PASSWORD),
            array('token', null, Client::AUTH_HTTP_TOKEN),
            array('token', null, Client::AUTH_URL_TOKEN),
            array('client_id', 'client_secret', Client::AUTH_URL_CLIENT_ID),
        );
    }

    /**
     * @test
     * @dataProvider getAuthenticationPartialData
     */
    public function shouldAuthenticateUsingGivenParameters($token, $method)
    {
        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())
            ->method('authenticate')
            ->with($token, null, $method);

        $client = new Client($httpClient);
        $client->authenticate($token, $method);
    }

    public function getAuthenticationPartialData()
    {
        return array(
            array('token', Client::AUTH_HTTP_TOKEN),
            array('token', Client::AUTH_URL_TOKEN),
        );
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldThrowExceptionWhenAuthenticatingWithoutMethodSet()
    {
        $httpClient = $this->getHttpClientMock(array('addListener'));

        $client = new Client($httpClient);
        $client->authenticate('login', null, null);
    }

    /**
     * @test
     */
    public function shouldClearHeadersLazy()
    {
        $httpClient = $this->getHttpClientMock(array('clearHeaders'));
        $httpClient->expects($this->once())->method('clearHeaders');

        $client = new Client($httpClient);
        $client->clearHeaders();
    }

    /**
     * @test
     */
    public function shouldSetHeadersLaizly()
    {
        $headers = array('header1', 'header2');

        $httpClient = $this->getHttpClientMock();
        $httpClient->expects($this->once())->method('setHeaders')->with($headers);

        $client = new Client($httpClient);
        $client->setHeaders($headers);
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetMagicApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->$apiName());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldNotGetApiInstance()
    {
        $client = new Client();
        $client->api('do_not_exist');
    }

    /**
     * @test
     * @expectedException BadMethodCallException
     */
    public function shouldNotGetMagicApiInstance()
    {
        $client = new Client();
        $client->doNotExist();
    }

    public function getApiClassesProvider()
    {
        return array(
            array('user', 'serverdensity\Api\User'),
            array('users', 'serverdensity\Api\User'),

            array('me', 'serverdensity\Api\CurrentUser'),
            array('current_user', 'serverdensity\Api\CurrentUser'),
            array('currentUser', 'serverdensity\Api\CurrentUser'),

            array('git', 'serverdensity\Api\GitData'),
            array('git_data', 'serverdensity\Api\GitData'),
            array('gitData', 'serverdensity\Api\GitData'),

            array('gist', 'serverdensity\Api\Gists'),
            array('gists', 'serverdensity\Api\Gists'),

            array('issue', 'serverdensity\Api\Issue'),
            array('issues', 'serverdensity\Api\Issue'),

            array('markdown', 'serverdensity\Api\Markdown'),

            array('organization', 'serverdensity\Api\Organization'),
            array('organizations', 'serverdensity\Api\Organization'),

            array('repo', 'serverdensity\Api\Repo'),
            array('repos', 'serverdensity\Api\Repo'),
            array('repository', 'serverdensity\Api\Repo'),
            array('repositories', 'serverdensity\Api\Repo'),

            array('search', 'serverdensity\Api\Search'),

            array('pr', 'serverdensity\Api\PullRequest'),
            array('pullRequest', 'serverdensity\Api\PullRequest'),
            array('pull_request', 'serverdensity\Api\PullRequest'),
            array('pullRequests', 'serverdensity\Api\PullRequest'),
            array('pull_requests', 'serverdensity\Api\PullRequest'),

            array('authorization', 'serverdensity\Api\Authorizations'),
            array('authorizations', 'serverdensity\Api\Authorizations'),

            array('meta', 'serverdensity\Api\Meta')
        );
    }

    public function getHttpClientMock(array $methods = array())
    {
        $methods = array_merge(
            array('get', 'post', 'patch', 'put', 'delete', 'request', 'setOption', 'setHeaders', 'authenticate'),
            $methods
        );

        return $this->getMock('serverdensity\HttpClient\HttpClientInterface', $methods);
    }
}
