<?php

namespace EdpGithubTest\Listener\Auth;

use EdpGithub\Listener\Auth\UrlClientId;
use PHPUnit_Framework_TestCase;

class UrlClientIdTest extends PHPUnit_Framework_TestCase
{
    private $event;

    public function setUp()
    {
        $this->event = $this->getMock('Zend\EventManager\Event');
    }

    public function testPreSend()
    {
        $request = new \Zend\Http\Request();
        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($request));

        $options = array(
            'tokenOrLogin'  => '1234',
            'password'      => 'somePassword',
        );
        $listener = new UrlClientId();
        $listener->setOptions($options);
        $listener->presend($this->event);

        $query = $request->getQuery();
        $this->assertEquals('1234', $query->client_id);
        $this->assertEquals('somePassword', $query->client_secret);
    }

    /**
     * Test if tokenOrLogin is not set
     * @expectedException EdpGithub\Listener\Auth\Exception\InvalidArgumentException
     */
    public function testPreSendFaultyOptions()
    {
        $listener = new UrlClientId();
        $listener->preSend($this->event);
    }

    /**
     * Test if tokenOrLogin is empty
     * @expectedException EdpGithub\Listener\Auth\Exception\InvalidArgumentException
     */
    public function testPreSendEmptyTokenOrLogin()
    {
        $options = array('tokenOrLogin' => '');
        $listener = new UrlClientId();
        $listener->setOptions($options);
        $listener->preSend($this->event);
    }
}
