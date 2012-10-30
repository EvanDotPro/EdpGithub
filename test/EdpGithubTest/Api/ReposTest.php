<?php

namespace EdpGithubTest\Api;

use EdpGithub\Api\Repos;

class ReposTest extends TestCase
{
    public function testShow()
    {
        $expectedArray = array('id' => 1, 'name' => 'EdpGithub');

        $client = $this->getClientMock('user', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->show('someUser');

        $this->assertInstanceOf('EdpGithub\Collection\RepositoryCollection', $result);
    }

    public function testContent()
    {
        $expectedArray = array('id' =>1, 'name' => 'repo');
        $client = $this->getClientMock('repos/vendor/repos/contents/readme', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->content('vendor/repos', 'readme');

        $this->assertEquals($result, $expectedArray);
    }
}
