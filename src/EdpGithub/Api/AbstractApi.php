<?php

namespace EdpGithub\Api;

use EdpGithub\Client;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

abstract class AbstractApi implements ServiceManagerAwareInterface
{
    /**
     * @var Client
     */
    protected $client;

    protected $response;

    /**
     * {@inheritDoc}
     */
    protected function get($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->getClient()->getHttpClient()->get($path, $parameters, $requestHeaders);

        return $response->getBody();
    }

    /**
     * {@inheritDoc}
     */
    protected function post($path, array $parameters = array(), $requestHeaders = array())
    {
        $response = $this->getClient()->getHttpClient()->post($path, $parameters, $requestHeaders);

        return $response->getBody();
    }

    /**
     * Get Client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }
    /**
     * Set Service Manager
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Get Service Manager
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}
