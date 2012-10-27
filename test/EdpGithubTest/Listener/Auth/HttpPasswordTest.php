<?php

namespace EdpGithubTest\Listener\Auth;

use PHPUnit_Framework_TestCase;
use EdpGithub\Listener\Auth\HttpPassword;

class HttpPasswordTest extends PHPUnit_Framework_TestCase
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
            'tokenOrLogin' => '1234',
            'password' => 'somePassword'
        );
        $listener = new HttpPassword();
        $listener->setOptions($options);
        $listener->presend($this->event);

        $headers = $request->getHeaders();
        $header = $headers->get('Authorization');

        $this->assertInstanceOf('Zend\Http\Header\Authorization', $header);
        $this->assertEquals('Basic MTIzNDpzb21lUGFzc3dvcmQ=', $header->getFieldValue());
    }

    /**
     * Test if tokenOrLogin and password are not set
     * @expectedException EdpGithub\Listener\Auth\Exception\InvalidArgumentException
     */
    public function testPreSendFaultyOptions()
    {
        $listener = new HttpPassword();
        $listener->preSend($this->event);
    }

    /**
     * Test if password is empty
     * @expectedException EdpGithub\Listener\Auth\Exception\InvalidArgumentException
     */
    public function testPreSendEmptyPassword()
    {
        $options = array('tokenOrLogin' => '1234', 'password' => '');
        $listener = new HttpPassword();
        $listener->setOptions($options);
        $listener->preSend($this->event);
    }

    /**
     * Test if tokenOrLogin is empty
     * @expectedException EdpGithub\Listener\Auth\Exception\InvalidArgumentException
     */
    public function testPreSendEmptyTokenOrLogin()
    {
        $options = array('tokenOrLogin' => '', 'password' => 'somePassword');
        $listener = new HttpPassword();
        $listener->setOptions($options);
        $listener->preSend($this->event);
    }
}