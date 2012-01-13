<?php

namespace EdpGithub\ApiClient;

use Zend\Http\Client as HttpClient,
    Zend\Json\Json,
    Zend\Session\Container,
    Zend\Session\Manager,
    Zend\Session\SessionManager;

class ApiClient
{
    const API_URI = 'https://api.github.com';

    /**
     * @var int
     */
    protected $rateLimitRemaining;

    /**
     * @var int
     */
    protected $rateLimit;

    /**
     * @var string
     */
    protected $oauthToken;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $services = array();

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Manager
     */
    protected $session;

    /**
     * Make a request to the GitHub API and decode the json response. 
     * 
     * @param string $uri
     * @param string $verb
     * @param array $params 
     * @return array
     */
    public function request($uri, $verb = 'GET', $params = array())
    {
        $client = $this->getHttpClient();
        $client->getRequest()->setUri(static::API_URI . $uri);
        $client->getRequest()->setMethod($verb);

        if (null !== $this->getOauthToken()) {
            $client->getRequest()->headers()->addHeaderLine('Authorization', 'token '.$this->getOauthToken());
        }

        $response = $client->send();
        $headers  = $response->headers();

        $this->setRateLimitRemaining($headers->get('X-RateLimit-Remaining')->getFieldValue());
        $this->setRateLimit($headers->get('X-RateLimit-Limit')->getFieldValue());

        return Json::decode($response->getBody(), Json::TYPE_ARRAY);
    }
 
    /**
     * Get rateLimitRemaining.
     *
     * @return int
     */
    public function getRateLimitRemaining()
    {
        return $this->rateLimitRemaining;
    }
 
    /**
     * Set rateLimitRemaining.
     *
     * @param int $rateLimitRemaining
     * @return ApiClient
     */
    public function setRateLimitRemaining($rateLimitRemaining)
    {
        $this->rateLimitRemaining = (int) $rateLimitRemaining;
        return $this;
    }
 
    /**
     * Get rateLimit.
     *
     * @return int
     */
    public function getRateLimit()
    {
        return $this->rateLimit;
    }
 
    /**
     * Set rateLimit.
     *
     * @param int $rateLimit
     * @return ApiClient
     */
    public function setRateLimit($rateLimit)
    {
        $this->rateLimit = (int) $rateLimit;
        return $this;
    }
 
    /**
     * Get oauthToken.
     *
     * @return string
     */
    public function getOauthToken()
    {
        return $this->oauthToken;
    }
 
    /**
     * Set oauthToken.
     *
     * @param string $oauthToken
     */
    public function setOauthToken($oauthToken)
    {
        $this->getContainer()->oauthToken = $oauthToken;
        $this->oauthToken = $oauthToken;
        return $this;
    }
 
    /**
     * Get HttpClient.
     *
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient;
        }
        return $this->httpClient;
    }
 
    /**
     * Set HttpClient.
     *
     * @param HttpClient $httpClient the value to be set
     * @return ApiClient
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * getService 
     * 
     * @param string $serviceName 
     * @return Service\ServiceAbstract
     */
    public function getService($serviceName)
    {
        $serviceName = ucfirst($serviceName);
        if (!isset($this->services[$serviceName])) {
            $serviceClass = "EdpGithub\ApiClient\Service\\{$serviceName}";
            $service      = new $serviceClass;
            $this->setService($serviceName, $service);
        }
        return $this->services[$serviceName];
    }

    /**
     * setService 
     * 
     * @param string $serviceName 
     * @param Service\AbstractService $service 
     * @return ApiClient
     */
    public function setService($serviceName, Service\AbstractService $service)
    {
        $service->setApiClient($this);
        $this->services[$serviceName] = $service;
        return $this;
    }

    /**
     * Set the session manager
     * 
     * @param  Manager $manager 
     * @return ApiClient
     */
    public function setSessionManager(Manager $manager)
    {
        $this->session = $manager;
        return $this;
    }

    /**
     * Retrieve the session manager
     *
     * If none composed, lazy-loads a SessionManager instance
     * 
     * @return Manager
     */
    public function getSessionManager()
    {
        if (!$this->session instanceof Manager) {
            $this->setSessionManager(new SessionManager());
        }
        return $this->session;
    }

    /**
     * Get session container for GitHub token
     * 
     * @return Container
     */
    public function getContainer()
    {
        if ($this->container instanceof Container) {
            return $this->container;
        }

        $manager = $this->getSessionManager();
        $this->container = new Container('EdpGithub', $manager);
        return $this->container;
    }
}
