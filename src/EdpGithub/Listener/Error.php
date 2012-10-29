<?php

namespace EdpGithub\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;

class Error implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    private $options;

    protected $listeners = array();

    public function attach(EventManagerInterface $events)
    {
        $em = $events->getSharedManager();
        $this->listeners[] = $em->attach('EdpGithub\Http\Client','post.send', array($this, 'postSend'));
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function postSend(Event $e)
    {
        $response = $e->getTarget();
        if($response->isSuccess()) {
            return true;
        }

        //Get Http Response Status Code
        $statusCode =  $response->getStatusCode();
        $content = json_decode($response->getBody());
        switch ($statusCode){
            case 400:
            case 401:
                throw new Exception\RuntimeException($content->message, $statusCode);
            break;
            case 422:
                $errors = array();
                foreach ($content->errors as $error) {
                    switch ($error->code) {
                        case 'missing':
                            $errors[] = sprintf('Resource "%s" not exists anymore', $error->resource);
                            break;

                        case 'missing_field':
                            $errors[] = sprintf('Field "%s" is missing, for resource "%s"', $error->field, $error->resource);
                            break;

                        case 'invalid':
                            $errors[] = sprintf('Field "%s" is invalid, for resource "%s"', $error->field, $error->resource);
                            break;

                        case 'already_exists':
                            $errors[] = sprintf('Field "%s" already exists, for resource "%s"', $error->field, $error->resource);
                            break;

                    }
                }
                throw new Exception\InvalidArgumentException('Validation Failed:' . implode(', ', $errors), $statusCode);
            break;
            default:
                throw new Exception\RuntimeException(isset($content->message) ? $content->message : $content, $statusCode);
            break;
        }
    }
}
