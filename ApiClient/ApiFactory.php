<?php

namespace EdpGithub\ApiClient;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApiFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $hybridAuth = $services->get('HybridAuth');
        $adapter = $hybridAuth->getAdapter('github');
        $token = $adapter->getAccessToken();
 
        $service = $services->get('edpgithub_api');
        $service->setOauthToken($token['access_token']);
        return $service;
    }
}