<?php

namespace EdpGithubTest\Api;

use EdpGithub\Api\Repos;

class ReposTest extends TestCase
{
    public function testShow()
    {
        $api = new Repos;
        $api->setClient($this->getClientMock());
        $repos = $api->show('user');

        $this->assertInstanceOf('EdpGithub\Collection\RepositoryCollection', $repos);
    }
}