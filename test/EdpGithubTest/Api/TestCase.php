<?php

namespace EdpGithubTest\Api;


use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{

    public function getHttpClientMock()
    {
        $response = $this->getMock('Zend\Http\Response');
        $response->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue('test'));

        $httpClient = $this->getMock('EdpGithub\Http\Client');
        $httpClient->expects($this->any())
            ->method('get')
            ->will($this->returnValue($response));

        return $httpClient;
    }

    public function getClientMock()
    {
        $client = $this->getMock('EdpGithub\Client');

        $client->expects($this->once())
            ->method('getHttpClient')
            ->will($this->returnValue($this->getHttpClientMock()));
        return $client;
    }
}