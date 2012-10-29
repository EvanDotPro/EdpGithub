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
        $expectedArray = array('id' => 1, 'username' => 'someUser');

        $client = $this->getClientMock('users/someUser', $expectedArray);
        $api = new User();
        $api->setClient($client);
        $result = $api->show('someUser');
        $this->assertEquals($result, $expectedArray);
    }
}
