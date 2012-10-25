<?php

namespace EdpGithub\Listener;

use EdpGithub\Client;

use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Buzz\Util\Url;

use Zend\EventManager\EventCollection;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

class AuthListener implements ListenerAggregateInterface
{
    /**
     * @var string
     */
    private $method;
    /**
     * @var array
     */
    private $options;

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
     * Set Method
     * @param string
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
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
    public function preSend(RequestInterface $request)
    {
        // Skip by default
        if (null === $this->method) {
            return;
        }

        switch ($this->method) {
            case Client::AUTH_HTTP_PASSWORD:
                if (!isset($this->options['tokenOrLogin'], $this->options['password'])) {
                    throw new Exception\InvalidArgumentException('You need to set username with password!');
                }

                $request->addHeader('Authorization: Basic '. base64_encode($this->options['tokenOrLogin'] .':'. $this->options['password']));
                break;

            case Client::AUTH_HTTP_TOKEN:
                if (!isset($this->options['tokenOrLogin'])) {
                    throw new Exception\InvalidArgumentException('You need to set OAuth token!');
                }

                $request->addHeader('Authorization: token '. $this->options['tokenOrLogin']);
                break;

            case Client::AUTH_URL_CLIENT_ID:
                if (!isset($this->options['tokenOrLogin'], $this->options['password'])) {
                    throw new Exception\InvalidArgumentException('You need to set client_id and client_secret!');
                }

                $url = $request->getUrl();

                $parameters = array(
                    'client_id'     => $this->options['tokenOrLogin'],
                    'client_secret' => $this->options['password'],
                );

                $url .= (false === strpos($url, '?') ? '?' : '&').utf8_encode(http_build_query($parameters, '', '&'));

                $request->fromUrl(new Url($url));
                break;

            case Client::AUTH_URL_TOKEN:
                if (!isset($this->options['tokenOrLogin'])) {
                    throw new Exception\InvalidArgumentException('You need to set OAuth token!');
                }

                $url  = $request->getUrl();
                $url .= (false === strpos($url, '?') ? '?' : '&').utf8_encode(http_build_query(array('access_token' => $this->options['tokenOrLogin']), '', '&'));

                $request->fromUrl(new Url($url));
                break;
        }
    }
}