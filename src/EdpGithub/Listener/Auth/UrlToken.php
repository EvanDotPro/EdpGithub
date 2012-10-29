<?php

namespace EdpGithub\Listener\Auth;

use Zend\EventManager\Event;
use Zend\Validator\NotEmpty;

class UrlToken extends AbstractAuthListener
{
    /**
     * Add access token to Request Parameters
     *
     * @throws Exception\InvalidArgumentException
     */
    public function preSend(Event $e)
    {
        $validator = new NotEmpty();

        if (
            !isset($this->options['tokenOrLogin'])
            || !$validator->isValid($this->options['tokenOrLogin'])
        ) {
            throw new Exception\InvalidArgumentException('You need to set OAuth token!');
        }


        $request = $e->getTarget();

        $query = $request->getQuery();
        $query->set('access_token', $this->options['tokenOrLogin']);
    }
}
