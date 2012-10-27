<?php

namespace EdpGithubTest\Api;

use EdpGithub\Api\CurrentUser;

class CurrentUserTest extends TestCase
{
    public function setUp()
    {
        // your code here
    }

    public function tearDown()
    {
        // your code here
    }

    public function testShow()
    {
        $this->markTestIncomplete( 'This test has not been implemented yet.' );
    }

    public function testRepos()
    {
        $api = new CurrentUser;
        $api->setClient($this->getClientMock());
        $repos = $api->repos();

        $this->assertInstanceOf('EdpGithub\Collection\RepositoryCollection', $repos);
    }
}