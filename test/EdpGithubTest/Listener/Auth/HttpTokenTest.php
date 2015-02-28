<?php

namespace EdpGithubTest\Listener\Auth;

use EdpGithub\Listener\Auth\HttpToken;
use PHPUnit_Framework_TestCase;

class HttpTokenTest extends PHPUnit_Framework_TestCase
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
            'tokenOrLogin' => '1234',
        );
        $listener = new HttpToken();
        $listener->setOptions($options);
        $listener->presend($this->event);

        $headers = $request->getHeaders();
        $header = $headers->get('Authorization');

        $this->assertInstanceOf('Zend\Http\Header\Authorization', $header);
        $this->assertEquals('token 1234', $header->getFieldValue());
    }

    /**
     * Test if tokenOrLogin is not set
     * @expectedException EdpGithub\Listener\Auth\Exception\InvalidArgumentException
     */
    public function testPreSendFaultyOptions()
    {
        $listener = new HttpToken();
        $listener->preSend($this->event);
    }

    /**
     * Test if tokenOrLogin is empty
     * @expectedException EdpGithub\Listener\Auth\Exception\InvalidArgumentException
     */
    public function testPreSendEmptyTokenOrLogin()
    {
        $options = array('tokenOrLogin' => '');
        $listener = new HttpToken();
        $listener->setOptions($options);
        $listener->preSend($this->event);
    }
}
