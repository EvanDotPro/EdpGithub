<?php

namespace EdpGithub\Listener\Auth;

use Zend\EventManager\Event;
use Zend\Validator\NotEmpty;

class UrlClientId extends AbstractAuthListener
{
    /**
     * Add Client Id and Client Secret to Request Parameters
     *
     * @throws Exception\InvalidArgumentException
     */
    public function preSend(Event $e)
    {
        $validator = new NotEmpty();

        if (
            !isset($this->options['tokenOrLogin'], $this->options['password'])
            || !$validator->isValid($this->options['tokenOrLogin'])
            || !$validator->isValid($this->options['password'])
        ) {
            throw new Exception\InvalidArgumentException('You need to set client_id and client_secret!');
        }

        $request = $e->getTarget();

        $query = $request->getQuery();
        $query->set('client_id', $this->options['tokenOrLogin']);
        $query->set('client_secret', $this->options['password']);
    }
}
