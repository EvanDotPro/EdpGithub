<?php

namespace EdpGithubTest\Listener\Auth;

use PHPUnit_Framework_TestCase;

use EdpGithub\Listener\Error;
use Zend\Http\Response;

class ErrorListenerTest extends PHPUnit_Framework_TestCase
{
    private $event;
    private $response;

    public function setUp()
    {
        $this->response = $this->getMock('Zend\Http\Response');
        $this->event = $this->getMock('Zend\EventManager\Event');
    }

    public function testPostSendSuccess()
    {
        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($this->response));

        $listener = new Error();
        $result = $listener->postSend($this->event);
        $this->assertTrue($result);
    }

    /**
     * Test for HTTP Status 400
     * @expectedException EdpGithub\Listener\Exception\RuntimeException
     */
    public function testPostSendBadRequest()
    {

        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(400));

        $content = '{"message":"testmessage"}';
        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));

        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($this->response));


        $listener = new Error();
        $result = $listener->postSend($this->event);
    }

    /**
     * Test for HTTP Status 401
     * @expectedException EdpGithub\Listener\Exception\RuntimeException
     */
    public function testPostSendUnauthorized()
    {
        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(401));

        $content = '{"message":"testmessage"}';
        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));

        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($this->response));


        $listener = new Error();
        $result = $listener->postSend($this->event);

    }

    /**
     * Test for HTTP Status 422
     * @expectedException EdpGithub\Listener\Exception\InvalidArgumentException
     */
    public function testPostSendUnprocessableEntity()
    {
        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(422));



        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($this->response));

        $content = '{"message":"testmessage", "errors": [{"code":"missing", "resource":"resource test"}]}';

        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));
        $listener = new Error();
        $result = $listener->postSend($this->event);
    }

    /**
     * Test for HTTP Error
     * @expectedException EdpGithub\Listener\Exception\RunTimeException
     */
    public function testPostSendFailed()
    {
        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(499));



        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($this->response));

            $content = '{"message":"testmessage", "errors": [{"code":"missing", "resource":"resource test"}]}';

        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));
        $listener = new Error();
        $result = $listener->postSend($this->event);
    }

    /**
     * Test for HTTP Error
     * @expectedException EdpGithub\Listener\Exception\InvalidArgumentException
     */
    public function testPostSendFailedMissingField()
    {
        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(422));

        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($this->response));

        $content = '{"message":"testmessage",'
            .' "errors": [{"code":"missing_field", "resource":"resource test", "field":"someField"}]}';

        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));
        $listener = new Error();
        $result = $listener->postSend($this->event);
    }

    /**
     * Test for HTTP Error
     * @expectedException EdpGithub\Listener\Exception\InvalidArgumentException
     */
    public function testPostSendFailedInvalid()
    {
        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(422));



        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($this->response));

        $content = '{"message":"testmessage",'
            .' "errors": [{"code":"invalid", "resource":"resource test", "field":"someField"}]}';

        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));
        $listener = new Error();
        $result = $listener->postSend($this->event);
    }

    /**
     * Test for HTTP Error
     * @expectedException EdpGithub\Listener\Exception\InvalidArgumentException
     */
    public function testPostSendFailedAlreadyExists()
    {
        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(422));

        $this->event->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($this->response));

        $content = '{"message":"testmessage",'.
            ' "errors": [{"code":"already_exists", "resource":"resource test", "field":"someField"}]}';

        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($content));
        $listener = new Error();
        $result = $listener->postSend($this->event);
    }
}
