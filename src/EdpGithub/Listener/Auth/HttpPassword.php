<?php

namespace EdpGithub\Listener\Auth;

use EdpGithub\Client;

use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Buzz\Util\Url;

use Zend\EventManager\EventCollection;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;

class HttpPassword implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    private $options;

    protected $listeners = array();

    public function attach(EventManagerInterface $events)
    {
        $em = $events->getSharedManager();
        $this->listeners[] = $em->attach('EdpGithub\HttpClient\HttpClient','pre.send', array($this, 'preSend'));
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Set Options
     * @param array
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception\InvalidArgumentException
     */
    public function preSend(Event $e)
    {
        if (!isset($this->options['tokenOrLogin'], $this->options['password'])) {
            throw new Exception\InvalidArgumentException('You need to set username with password!');
        }

        $request->addHeader('Authorization: Basic '. base64_encode($this->options['tokenOrLogin'] .':'. $this->options['password']));
    }
}