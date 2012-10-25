<?php

namespace EdpGithub\Listener\Auth;

use Zend\EventManager\Event;

class UrlToken extends AbstractAuthListener
{
    /**
     * Add access token to Request Parameters
     *
     * @throws Exception\InvalidArgumentException
     */
    public function preSend(Event $e)
    {
        if (!isset($this->options['tokenOrLogin'])) {
            throw new Exception\InvalidArgumentException('You need to set OAuth token!');
        }


        $request = $e->getTarget();

        $query = $request->getQuery();
        $query->set('access_token', $this->options['tokenOrLogin']);
    }
}