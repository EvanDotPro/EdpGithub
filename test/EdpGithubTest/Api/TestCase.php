<?php

namespace EdpGithubTest\Api;


use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase
{
    public function getClientMock($expectedPath, $expectedResult)
    {
        $response = $this->getMock('Zend\Http\Response');
        $response->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue($expectedResult));

        $httpClient = $this->getMock('EdpGithub\Http\Client');
        $httpClient->expects($this->any())
            ->method('get')
            ->with($expectedPath)
            ->will($this->returnValue($response));

        $httpClient->expects($this->any())
            ->method('post')
            ->with($expectedPath)
            ->will($this->returnValue($response));

        $client = $this->getMock('EdpGithub\Client');

        $client->expects($this->once())
            ->method('getHttpClient')
            ->will($this->returnValue($httpClient));
        return $client;
    }
}
