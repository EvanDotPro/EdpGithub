<?php

namespace EdpGithub;

use Zend\ModuleManager\ModuleManager,
    Zend\EventManager\StaticEventManager;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'EdpGithub\Client' => function($sm) {
                    $em = $sm->get('EventManager');
                    $client = new Client($em, $sm);
                    return $client;
                },
                'EdpGithub\CurrentUser' => function($sm) {
                    $service = new Api\CurrentUser();
                    $service->setClient($sm->get('EdpGithub\Client'));
                    return $service;
                },
                'EdpGithub\User'        => function($sm) {
                    $service = new Api\User();
                    $service->setClient($sm->get('EdpGithub\Client'));
                    return $service;
                },
                'EdpGithub\Repository'  => function($sm) {
                    $service = new Api\Repository();
                    $service->setClient($sm->get('EdpGithub\Client'));
                    return $service;
                },
                'EdpGithub\Gist'        => function($sm) {
                    $service = new Api\Gist();
                    $service->setClient($sm->get('EdpGithub\Client'));
                    return $service;
                },
                'EdpGithub\GitData'     => function($sm) {
                    $service = new Api\GitData();
                    $service->setClient($sm->get('EdpGithub\Client'));
                    return $service;
                },
                'EdpGithub\Organization'=> function($sm) {
                    $service = new Api\Organization();
                    $service->setClient($sm->get('EdpGithub\Client'));
                    return $service;
                },
                'EdpGithub\PullRequest' => function($sm) {
                    $service = new Api\PullRequest();
                    $service->setClient($sm->get('EdpGithub\Client'));
                    return $service;
                },
                'EdpGithub\Repository'  => function($sm) {
                    $service = new Api\Repository();
                    $service->setClient($sm->get('EdpGithub\Client'));
                    return $service;
                },
                'EdpGithub\Issue'       => function($sm) {
                    $service = new Api\Issue();
                    $service->setClient($sm->get('EdpGithub\Client'));
                    return $service;
                },
            ),
        );
    }
}
