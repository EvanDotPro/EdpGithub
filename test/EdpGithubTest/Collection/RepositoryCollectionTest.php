<?php

namespace EdpGithubTest\Collection;

use EdpGithub\Collection\RepositoryCollection;
use PHPUnit_Framework_TestCase;

class RepositoryCollectionTest extends PHPUnit_Framework_TestCase
{
    public function getClientMock($expectedPath, $expectedResult)
    {
        $response = $this->getMock('Zend\Http\Response');
        $response->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue($expectedResult));

        $headers = $this->getMock('Zend\Http\Headers');
        $headers->expects($this->any())
            ->method('has')
            ->with('Link')
            ->will($this->returnValue(true));

        $link = $this->getMock('Zend\Http\Header\GenericHeader');
        $link->expects($this->any())
            ->method('getFieldValue')
            ->will($this->returnValue(
                '<https://api.github.com?page=1&per_page=30>;'
                .'rel="next", <https://api.github.com?page=1&per_page=30>; rel="last"'
            ));

        $headers->expects($this->any())
            ->method('get')
            ->with('Link')
            ->will($this->returnValue($link));

        $response->expects($this->any())
            ->method('getHeaders')
            ->will($this->returnValue($headers));


        $httpClient = $this->getMock('EdpGithub\Http\Client');
        $httpClient->expects($this->any())
            ->method('get')
            ->with($expectedPath)
            ->will($this->returnValue($response));


        return $httpClient;
    }

    public function testPage()
    {
        $json = '[{"id":"1","name":"someRepo"},{"id":"2","name":"anotherRepo"}]';

        $httpClient = $this->getClientMock('user/repos', $json);
        $repoCollection = new RepositoryCollection($httpClient, 'user/repos');

        $result = $repoCollection->page(1);
        $expectedResult = json_decode($json);
        $this->assertEquals($expectedResult, $result);

        return $repoCollection;
    }

    /**
     * @depends testPage
     */
    public function testGet($repoCollection)
    {
        $json = '{"id":"2","name":"anotherRepo"}';
        $result = $repoCollection->get(1);
        $expectedResult = json_decode($json);
        $this->assertEquals($expectedResult, $result);
        return $repoCollection;
    }

    /**
     * @depends testGet
     */
    public function testKey($repoCollection)
    {
        $result = $repoCollection->key();
        $this->assertEquals($result, 0);

        return $repoCollection;
    }

    /**
     * @depends testKey
     */
    public function testFirst($repoCollection)
    {
        $json = '{"id":"1","name":"someRepo"}';
        $result = $repoCollection->first();

        $expectedResult = json_decode($json);
        $this->assertEquals($result, $expectedResult);

        return $repoCollection;
    }

    /**
     * @depends testFirst
     */
    public function testNext($repoCollection)
    {
        $json = '{"id":"2","name":"anotherRepo"}';
        $result = $repoCollection->next();
        $expectedResult = json_decode($json);
        $this->assertEquals($expectedResult, $result);
        return $repoCollection;
    }

    /**
     * @depends testNext
     */
    public function testPrev($repoCollection)
    {
        $json = '{"id":"1","name":"someRepo"}';
        $result = $repoCollection->prev();
        $expectedResult = json_decode($json);
        $this->assertEquals($expectedResult, $result);
        return $repoCollection;
    }

    /**
     * @depends testPrev
     */
    public function testContainsKey($repoCollection)
    {
        $result = $repoCollection->containsKey(1);
        $this->assertTrue($result);
        return $repoCollection;
    }

    /**
     * @depends testContainsKey
     */
    public function testCount($repoCollection)
    {
        $result = $repoCollection->count();
        $this->assertEquals($result, 2);
        return $repoCollection;
    }

    /**
     * @depends testCount
     */
    public function testIndexOf($repoCollection)
    {
        $json = '{"id":"2","name":"anotherRepo"}';
        $expectedResult = json_decode($json);
        $result = $repoCollection->indexOf($expectedResult);
        $this->assertEquals($result, 1);
        return $repoCollection;
    }

    /**
     * @depends testIndexOf
     */
    public function testRemoveElement($repoCollection)
    {
        $json = '{"id":"2","name":"anotherRepo"}';
        $expectedResult = json_decode($json);
        $result = $repoCollection->removeElement($expectedResult);
        $this->assertTrue($result);
        return $repoCollection;
    }

    /**
     * @depends testRemoveElement
     */
    public function testRemoveElementFalse($repoCollection)
    {
        $json = '{"id":"2","name":"anotherRepo"}';
        $expectedResult = json_decode($json);
        $result = $repoCollection->removeElement($expectedResult);
        $this->assertFalse($result);
        return $repoCollection;
    }

    /**
     * @depends testRemoveElement
     */
    public function testCurrent($repoCollection)
    {
        $json = '{"id":"1","name":"someRepo"}';
        $expectedResult = json_decode($json);
        $result = $repoCollection->current();
        $this->assertEquals($result, $expectedResult);
        return $repoCollection;
    }

    /**
     * @depends testCurrent
     */
    public function testValid($repoCollection)
    {
        $result = $repoCollection->valid();
        $this->assertTrue($result);
        return $repoCollection;
    }

    /**
     * @depends testValid
     */
    public function testInValid($repoCollection)
    {
        $json = '[]';

        $httpClient = $this->getClientMock('user/repos', $json);
        $repoCollection->setHttpClient($httpClient);

        $repoCollection->next();
        $result = $repoCollection->valid();
        $this->assertFalse($result);
        return $repoCollection;
    }

    /**
     * @depends testInValid
     */
    public function testGetIterator($repoCollection)
    {
        $result = $repoCollection->getIterator();
        $this->assertInstanceOf('Iterator', $result);
        return $repoCollection;
    }
}
