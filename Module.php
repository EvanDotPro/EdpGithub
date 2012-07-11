<?php

namespace EdpGithub;

class Module
{
    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'edpgithub_module_options' => function ($sm) {
                    $config = $sm->get('Configuration');
                    return new Options(isset($config['edpgithub']) ? $config['edpgithub'] : array());
                },
                'edpgithub_usergithub_mapper' => function ($sm) {
                    $mapper = new Mapper\UserGithub;
                    $mapper->setDbAdapter($sm->get('edpgithub_zend_db_adapter'));
                    $mapper->setZfcUserOptions($sm->get('zfcuser_module_options'));
                    return $mapper;
                },
                'EdpGithub\Authentication\Adapter\ZfcUserGithub' => function($sm) {
                    $adapter = new Authentication\Adapter\ZfcUserGithub;
                    $adapter->setMapper($sm->get('edpgithub_usergithub_mapper'));
                    $adapter->setZfcUserOptions($sm->get('zfcuser_module_options'));
                    $adapter->setOptions($sm->get('edpgithub_module_options'));
                    //$adapter->setUserService(); // @todo
                    $adapter->setZfcUserMapper($sm->get('zfcuser_user_mapper'));
                    return $adapter;
                },
                // Only attach the github auth adapter
                'ZfcUser\Authentication\Adapter\AdapterChain' => function($sm) {
                    $adapterChain = new \ZfcUser\Authentication\Adapter\AdapterChain;
                    $adapter = $sm->get('EdpGithub\Authentication\Adapter\ZfcUserGithub');
                    $adapterChain->getEventManager()->attach('authenticate', array($adapter, 'authenticate'));
                    return $adapterChain;
                }
            ),
        );
    }

    public function onBootstrap($e)
    {
        $events = $e->getApplication()->getEventManager()->getSharedManager();
        $events->attach('ZfcUser\Authentication\Adapter\AdapterChain', 'authenticate.pre', function($e) {
            die('auth!');
        });
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
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
}
