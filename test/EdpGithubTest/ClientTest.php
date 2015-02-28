<?php

namespace EdpGithubTest;

use EdpGithub\Client;
use PHPUnit_Framework_TestCase;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\ServiceManager;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    protected $serviceManager;

    public function setUp()
    {
        $this->serviceManager = new ServiceManager();
        $this->serviceManager->setService('EdpGithub\HttpClient', $this->getHttpClient('foo', 'bar'));
        $this->serviceManager->setService('EdpGithub\Listener\Error', $this->getMock('EdpGithub\Listener\Error'));
        $this->serviceManager->setService('EdpGithub\Listener\Cache', $this->getMock('EdpGithub\Listener\Cache'));
    }

    public function getHttpClient($path)
    {
        $response = $this->getMock('Zend\Http\Response');
        $eventManager = new EventManager();

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
        $this->client = new Client();
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
                'password' => null,
            ));

        $sm = $this->getMock('Zend\ServiceManager\ServiceManager');
        $sm->expects($this->once())
            ->method('get')
            ->with('EdpGithub\Listener\Auth\UrlToken')
            ->will($this->returnValue($authListener));

        $this->client = new Client();
        $this->client->setServiceManager($sm);
        $this->client->setHttpClient($this->getHttpClient('test'));
        $this->client->authenticate('url_token', '12345');
    }

    public function testSetServiceManager()
    {
        $client = new Client();
        $client->setServiceManager($this->serviceManager);

        $this->assertInstanceOf('Zend\ServiceManager\ServiceManager', $client->getServiceManager());
    }

    public function testGetHttpClient()
    {
        $client = new Client();
        $client->setServiceManager($this->serviceManager);

        $httpClient = $client->getHttpClient();

        $this->assertInstanceOf('EdpGithub\Http\Client', $httpClient);
    }

    public function testSetEventManager()
    {
        $client = new Client();
        $result = $client->setEventManager(new EventManager());

        $this->assertInstanceOf('EdpGithub\Client', $result);
    }

    public function testApi()
    {
        $client = new Client();
        $serviceManager = $this->getMock('Zend\ServiceManager\ServiceManager');
        $serviceManager->expects($this->once())
            ->method('get')
            ->with($this->equalTo('EdpGithub\Api\CurrentUser'))
            ->will($this->returnValue($this->getMock('EdpGithub\Api\CurrentUser')));
        $client->setServiceManager($serviceManager);
        $result = $client->api('current_user');
    }
}
