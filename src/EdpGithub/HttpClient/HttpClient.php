<?php

namespace EdpGithub\HttpClient;

use Buzz\Client\ClientInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Buzz\Listener\ListenerInterface;

use EdpGithub\HttpClient\Listener\ErrorListener;
use EdpGithub\HttpClient\Message\Request;
use EdpGithub\HttpClient\Message\Response;

class HttpClient implements HttpClientInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $listeners = array();
    /**
     * @var array
     */
    protected $headers = array();

    private $lastResponse;
    private $lastRequest;

    /**
     * @param array           $options
     * @param ClientInterface $client
     */
    public function __construct(array $options, ClientInterface $client)
    {
        $this->options = $options;
        $this->client  = $client;

        $this->addListener(new ErrorListener($this->options));

        $this->clearHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), array $headers = array())
    {
        if (0 < count($parameters)) {
            $path .= (false === strpos($path, '?') ? '?' : '&').http_build_query($parameters, '', '&');
        }

        return $this->request($path, array(), 'GET', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'POST', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, array $parameters = array(), array $headers = array())
    {
        return $this->request($path, $parameters, 'DELETE', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, array $headers = array())
    {
        return $this->request($path, array(), 'PUT', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        $path = trim($this->options['base_url'].$path, '/');

        $request = $this->createRequest($httpMethod, $path);
        $request->addHeaders($headers);
        $request->setContent(json_encode($parameters));

        $hasListeners = 0 < count($this->listeners);
        if ($hasListeners) {
            foreach ($this->listeners as $listener) {
                $listener->preSend($request);
            }
        }

        $response = new Response();
        try {
            $this->client->send($request, $response);
        } catch (\LogicException $e) {
            throw new ErrorException($e->getMessage());
        } catch (\RuntimeException $e) {
            throw new RuntimeException($e->getMessage());
        }

        $this->lastRequest  = $request;
        $this->lastResponse = $response;

        if ($hasListeners) {
            foreach ($this->listeners as $listener) {
                $listener->postSend($request, $response);
            }
        }

        $response->getApiLimit();

        return $response;
    }

    /**
     * @param string $httpMethod
     * @param string $url
     *
     * @return Request
     */
    private function createRequest($httpMethod, $url)
    {
        $request = new Request($httpMethod);
        $request->setHeaders($this->headers);
        $request->fromUrl($url);

        return $request;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Clears used headers
     */
    public function clearHeaders()
    {
        $this->headers = array(
            sprintf('Accept: application/vnd.github.%s+json', $this->options['api_version'])
        );
    }

    /**
     * @param ListenerInterface $listener
     */
    public function addListener(ListenerInterface $listener)
    {
        $this->listeners[get_class($listener)] = $listener;
    }

    /**
     * Get Listener
     * @return array
     */
    public function getListener()
    {
        return $this->listeners;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }
}