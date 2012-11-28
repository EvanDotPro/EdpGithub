<?php

namespace EdpGithub;

use Zend\ModuleManager\ModuleManager,
    Zend\EventManager\StaticEventManager,
    Zend\Cache\StorageFactory;

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
                /**
                 * Cache where the API will be stored once it is filled with data
                 */
                'edpgithub.cache' => function($sm) {
                    $config = $sm->get('Config');
                    $storage = StorageFactory::factory($config['edpgithub']['cache']);

                    return $storage;
                },
            ),
        );
    }
}
