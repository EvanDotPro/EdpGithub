<?php

namespace EdpGithubTest\Api;

use EdpGithub\Api\CurrentUser;
use EdpGithub\Collection\RepositoryCollection;
class CurrentUserTest extends TestCase
{
    public function testShow()
    {
        $expectedArray = array('id' => 1, 'username' => 'someUser');

        $client = $this->getClientMock('user', $expectedArray);
        $api = new CurrentUser();
        $api->setClient($client);
        $result = $api->show();
        $this->assertEquals($result, $expectedArray);
    }

    public function testRepos()
    {
        $expectedArray = array('id' => 1, 'name' => 'EdpGithub');

        $client = $this->getClientMock('user', $expectedArray);
        $api = new CurrentUser();
        $api->setClient($client);
        $result = $api->repos();

        $this->assertInstanceOf('EdpGithub\Collection\RepositoryCollection', $result);
    }
}