<?php


namespace EdpGithub\Listener\Auth;

use Zend\EventManager\Event;

class HttpToken  extends AbstractAuthListener
{
    /**
     * Add Authorization Token to Header
     *
     * @throws Exception\InvalidArgumentException
     */
    public function preSend(Event $e)
    {
        if (!isset($this->options['tokenOrLogin'])) {
            throw new Exception\InvalidArgumentException('You need to set OAuth token!');
        }

        $request = $e->getTarget();

        $headers = $request->getHeaders();
        $params = array(
            'Authorization' => 'token '. $this->options['tokenOrLogin'],
        );
        $header->addHeaders($params);
    }
}