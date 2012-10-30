<?php

namespace EdpGithub\Listener\Auth;


use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;

use Zend\Http\Header\Authorization;

abstract class AbstractAuthListener implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    protected $options;

    protected $listeners = array();

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('pre.send', array($this, 'preSend'));
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

    abstract public function preSend(Event $e);
}
