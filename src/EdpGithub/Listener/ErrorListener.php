<?php

namespace EdpGithub\HttpClient\Listener;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Github\Exception\ApiLimitExceedException;
use Github\Exception\ErrorException;
use Github\Exception\RuntimeException;
use Github\Exception\ValidationFailedException;


use Zend\EventManager\EventCollection;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventInterface;

class ErrorListener implements ListenerInterface, ListenerAggregateInterface
{
    /**
     * @var array
     */
    private $options;

    protected $listeners = array();

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function attach(EventCollection $vents)
    {
        $this->listeners[] = $events->attach('EdpGithub\HttpClient\HttpClient', 'post.send', array($this, 'preSend'));
    }


    /**
     * {@inheritDoc}
     */
    public function postSend(RequestInterface $request, MessageInterface $response)
    {
        /** @var $response \Github\HttpClient\Message\Response */
        if ($response->isClientError() || $response->isServerError()) {
            $remaining = $response->getHeader('X-RateLimit-Remaining');
            if (null !== $remaining && 1 > $remaining) {
                throw new ApiLimitExceedException($this->options['api_limit']);
            }

            $content = $response->getContent();
            if (is_array($content) && isset($content['message'])) {
                if (400 == $response->getStatusCode()) {
                    throw new ErrorException($content['message'], 400);
                } elseif (422 == $response->getStatusCode() && isset($content['errors'])) {
                    $errors = array();
                    foreach ($content['errors'] as $error) {
                        switch ($error['code']) {
                            case 'missing':
                                $errors[] = sprintf('Resource "%s" not exists anymore', $error['resource']);
                                break;

                            case 'missing_field':
                                $errors[] = sprintf('Field "%s" is missing, for resource "%s"', $error['field'], $error['resource']);
                                break;

                            case 'invalid':
                                $errors[] = sprintf('Field "%s" is invalid, for resource "%s"', $error['field'], $error['resource']);
                                break;

                            case 'already_exists':
                                $errors[] = sprintf('Field "%s" already exists, for resource "%s"', $error['field'], $error['resource']);
                                break;

                        }
                    }

                    throw new ValidationFailedException('Validation Failed:' . implode(', ', $errors), 422);
                }
            }

            throw new RuntimeException(isset($content['message']) ? $content['message'] : $content, $response->getStatusCode());
        }
    }
}
