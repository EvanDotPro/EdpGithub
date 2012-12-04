<?php

namespace EdpGithubTest\Api;

use EdpGithub\Api\Repos;

class ReposTest extends TestCase
{
    public function testShow()
    {
        $expectedArray = array('id' => 1, 'name' => 'EdpGithub');

        $client = $this->getClientMock('repos/user/repo', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->show('user', 'repo');

        $this->assertEquals($expectedArray, $result);
    }

    public function testContent()
    {
        $expectedArray = array('id' =>1, 'name' => 'repo');
        $client = $this->getClientMock('repos/owner/repo/contents/path', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->content('owner', 'repo', 'path');

        $this->assertEquals($result, $expectedArray);
    }

    public function testReadme()
    {
        $expectedArray = array('id' =>1, 'name' => 'repo');
        $client = $this->getClientMock('repos/owner/repo/readme', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->readme('owner', 'repo');

        $this->assertEquals($result, $expectedArray);
    }
}
