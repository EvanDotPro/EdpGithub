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
        $expectedArray = array('id' => 1, 'name' => 'repo');
        $client = $this->getClientMock('repos/owner/repo/contents/path', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->content('owner', 'repo', 'path');

        $this->assertEquals($result, $expectedArray);
    }

    public function testReadme()
    {
        $expectedArray = array('id' => 1, 'name' => 'repo');
        $client = $this->getClientMock('repos/owner/repo/readme', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->readme('owner', 'repo');

        $this->assertEquals($result, $expectedArray);
    }

    public function testContributors()
    {
        $expectedArray = array('id' => 1, 'name' => 'repo');
        $client = $this->getClientMock('repos/owner/repo/stats/contributors', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->contributors('owner', 'repo');

        $this->assertEquals($result, $expectedArray);
    }

    public function testCommitActivity()
    {
        $expectedArray = array('id' => 1, 'name' => 'repo');
        $client = $this->getClientMock('repos/owner/repo/stats/commit_activity', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->commitActivity('owner', 'repo');

        $this->assertEquals($result, $expectedArray);
    }

    public function testCodeFrequency()
    {
        $expectedArray = array('id' => 1, 'name' => 'repo');
        $client = $this->getClientMock('repos/owner/repo/stats/code_frequency', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->codeFrequency('owner', 'repo');

        $this->assertEquals($result, $expectedArray);
    }

    public function testPartecipation()
    {
        $expectedArray = array('id' => 1, 'name' => 'repo');
        $client = $this->getClientMock('repos/owner/repo/stats/participation', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->partecipation('owner', 'repo');

        $this->assertEquals($result, $expectedArray);
    }

    public function testPunchCard()
    {
        $expectedArray = array('id' => 1, 'name' => 'repo');
        $client = $this->getClientMock('repos/owner/repo/stats/punch_Card', $expectedArray);
        $api = new Repos();
        $api->setClient($client);
        $result = $api->punchCard('owner', 'repo');

        $this->assertEquals($result, $expectedArray);
    }
}
