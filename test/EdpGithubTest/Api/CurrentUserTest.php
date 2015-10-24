<?php

namespace EdpGithubTest\Api;

use EdpGithub\Api\CurrentUser;
use Zend\ServiceManager\ServiceManager;

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

    public function testOrgs()
    {
        $expectedString = '[{"id":"1","name":"EdpGithub"}]';
        $expectedArray = json_decode($expectedString);
        $client = $this->getClientMock('user/orgs', $expectedString);
        $api = new CurrentUser();
        $api->setClient($client);
        $result = $api->orgs();
        $this->assertEquals($expectedArray, $result);
    }

    public function testgetServiceManager()
    {
        $serviceManager = new ServiceManager();
        $currentUser = new CurrentUser();
        $currentUser->setServiceManager($serviceManager);
        $this->assertInstanceOf('Zend\ServiceManager\ServiceManager', $currentUser->getServiceManager());
    }
}
