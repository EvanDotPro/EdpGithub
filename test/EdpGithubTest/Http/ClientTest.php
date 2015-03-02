<?php

namespace EdpGithubTest\Http;

use EdpGithub\Http\Client;
use PHPUnit_Framework_TestCase;
use Zend\EventManager\EventManager;
use Zend\Http\Headers;

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
            '{' .
            '    "id": 1,' .
            '    "name": "EdpGithub",' .
            '}'
        );
        $this->client->setHttpAdapter($adapter);

        $eventManager = new EventManager();
        $this->client->setEventManager($eventManager);
    }

    public function testHttpAdapterGetsCreatedWithOptions()
    {
        $client = new Client();
        $httpAdapter = $client->getHttpAdapter();

        $this->assertInstanceOf('Zend\Http\Client\Adapter\Curl', $httpAdapter);

        $httpOptions = $httpAdapter->getConfig();
        $this->assertArrayHasKey('curloptions', $httpOptions);
        $this->assertArrayHasKey(CURLOPT_SSL_VERIFYPEER, $httpOptions['curloptions']);
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

    public function testHeadersAreSet()
    {
        $headerName = 'Accept';
        $headerValue = 'application/vnd.github.full+json';
        $this->client->request('user', array(), 'GET', array($headerName => $headerValue));

        /* @var Headers $headers */
        $headers = $this->client->getRequest()->getHeaders();

        $this->assertTrue($headers->has($headerName));
        $this->assertSame($headerValue, $headers->get($headerName)->getFieldValue());
    }
}
