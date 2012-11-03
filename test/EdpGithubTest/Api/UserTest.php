<?php

namespace EdpGithubTest\Api;

use EdpGithub\Api\User;

class UserTest extends TestCase
{
    public function tearDown()
    {
        // your code here
    }

    public function testShow()
    {
        $expectedArray = array('id' => 1, 'username' => 'user');

        $client = $this->getClientMock('users/user', $expectedArray);
        $api = new User();
        $api->setClient($client);
        $result = $api->show('user');
        $this->assertEquals($result, $expectedArray);
    }

    public function testRepos()
    {
        $expectedArray = array('id' => 1, 'username' => 'user');

        $client = $this->getClientMock('users/user', $expectedArray);
        $api = new User();
        $api->setClient($client);
        $result = $api->repos('user');

        $this->assertInstanceOf('EdpGithub\Collection\RepositoryCollection', $result);
    }
}
