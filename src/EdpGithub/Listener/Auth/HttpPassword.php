<?php

namespace EdpGithub\Listener\Auth;

use Zend\EventManager\Event;

class HttpPassword extends AbstractAuthListener
{
    /**
     *  Add Basic Authnentication to Header
     *
     * @throws Exception\InvalidArgumentException
     */
    public function preSend(Event $e)
    {
        if (!isset($this->options['tokenOrLogin'], $this->options['password'])) {
            throw new Exception\InvalidArgumentException('You need to set username with password!');
        }

        $request = $e->getTarget();

        $headers = $request->getHeaders();
        $params = array(
            'Authorization' => 'Basic '. base64_encode($this->options['tokenOrLogin'] .':'. $this->options['password']),
        );
        $header->addHeaders($params);
    }
}