<?php

namespace EdpGithubTest;

use EdpGithub\Client;
use PHPUnit_Framework_TestCase;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function getHttpClient($path)
    {
        $response = $this->getMock('Zend\Http\Response');
        $eventManager = $this->getMock('Zend\EventManager\EventManager');

        $httpClient = $this->getMock('EdpGithub\Http\Client');
        $httpClient->expects($this->any())
            ->method('get')
            ->with($path)
            ->will($this->returnValue($response));

        $httpClient->expects($this->any())
            ->method('getEventManager')
            ->will($this->returnValue($eventManager));

        return $httpClient;
    }

    public function testGet()
    {
        $this->client= new Client();
        $this->client->setHttpClient($this->getHttpClient('test/path'));

        $result = $this->client->getHttpClient()->get('test/path');
        $this->assertInstanceOf('Zend\Http\Response', $result);
    }

    public function testAuthenticate()
    {
        $authListener = $this->getMock('EdpGithub\Listener\Auth\UrlToken');
        $authListener->expects($this->once())
            ->method('setOptions')
            ->with(array(
                'tokenOrLogin' => '12345',
                'password' =>null,
            ));

        $sm = $this->getMock('Zend\ServiceManager\ServiceManager');
        $sm->expects($this->once())
            ->method('get')
            ->with('EdpGithub\Listener\Auth\UrlToken')
            ->will($this->returnValue($authListener));

        $this->client = new Client();
        $this->client->setServiceManager($sm);
        $this->client->setHttpClient($this->getHttpClient('test'));
        $this->client->authenticate('url_token','12345');

    }

}
