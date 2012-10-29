<?php

namespace EdpGithubTest\Listener\Auth;

use PHPUnit_Framework_TestCase;
use EdpGithub\Listener\Auth\UrlToken;

class UrlTokenTest extends PHPUnit_Framework_TestCase
{
    private $event;

    public function setUp()
    {
        $this->event = $this->getMock('Zend\EventManager\Event');
    }

    public function testPreSend()
    {
        $request = new \Zend\Http\Request;
        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($request));


        $options = array(
            'tokenOrLogin'  => '1234',
        );
        $listener = new UrlToken();
        $listener->setOptions($options);
        $listener->presend($this->event);

        $query = $request->getQuery();
        $this->assertEquals('1234', $query->access_token);
    }

    /**
     * Test if tokenOrLogin is not set
     * @expectedException EdpGithub\Listener\Auth\Exception\InvalidArgumentException
     */
    public function testPreSendFaultyOptions()
    {
        $listener = new UrlToken();
        $listener->preSend($this->event);
    }

    /**
     * Test if tokenOrLogin is empty
     * @expectedException EdpGithub\Listener\Auth\Exception\InvalidArgumentException
     */
    public function testPreSendEmptyTokenOrLogin()
    {
        $options = array('tokenOrLogin' => '');
        $listener = new UrlToken();
        $listener->setOptions($options);
        $listener->preSend($this->event);
    }
}
