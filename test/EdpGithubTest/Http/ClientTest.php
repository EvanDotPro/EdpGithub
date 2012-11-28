<?php

namespace EdpGithubTest\Http;

use PHPUnit_Framework_TestCase;
use EdpGithub\Http\Client;
use Zend\EventManager\EventManager;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Client();

        $adapter = new \Zend\Http\Client\Adapter\Test();
        $adapter->setResponse(
            "HTTP/1.1 200 OK"      . "\r\n" .
            "Status: 200 OK"             . "\r\n" .
            "Content-Type: application/json; charset=utf-8" . "\r\n" .
                                        "\r\n" .
            '{'.
            '    "id": 1,'.
            '    "name": "EdpGithub",'.
            '}');
        $this->client->setHttpAdapter($adapter);

        $eventManager = new EventManager();
        $this->client->setEventManager($eventManager);

    }

    public function tearDown()
    {
        // your code here
    }

    public function testGet()
    {
        $response = $this->client->get('user');
        $this->assertInstanceOf('Zend\Http\Response', $response);
    }

    public function testPost()
    {
        $response = $this->client->post('user');
        $this->assertInstanceOf('Zend\Http\Response', $response);
    }
}
