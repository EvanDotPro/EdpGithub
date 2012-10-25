<?php

namespace EdpGithub\Api;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

abstract class AbstractApi implements ServiceManagerAwareInterface
{
    /**
     * @var EdpGithub\Client
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
     * Get Client
     * @return EdpGithub\Client
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