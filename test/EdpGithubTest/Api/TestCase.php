<?php

namespace EdpGithubTest\Api;


use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{

    public function getHttpClientMock()
    {
        $httpClient = $this->getMock('EdpGithub\Http\Client');

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