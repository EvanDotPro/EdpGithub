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
                    __NAMESPACE__ => __DIR__ ,
                ),
            ),
        );
    }
    /*protected static $options;

    public function init(ModuleManager $moduleManager)
    {
        $moduleManager->events()->attach('loadModules.post', array($this, 'modulesLoaded'));

        $events = StaticEventManager::getInstance();
        // @TODO: Clean this up
        $events->attach('Zend\Mvc\Controller\ActionController', 'dispatch', function($e) {
            $controller = $e->getTarget();
            $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
            $allowedRoutes = array('github/email', 'zfcuser/logout');
            if (in_array($matchedRoute, $allowedRoutes)) {
                return;
            }
            if ($identity = $controller->zfcUserAuthentication()->getIdentity()) {
                $email = $identity->getEmail();
                if ('@github.com' === substr($email, -11)) {
                    return $controller->redirect()->toRoute('github/email');
                }
            }
        }, 1000);
        // @TODO: Make it configurable how it attaches the adapter
        //$events = StaticEventManager::getInstance();
        //
        // This is for GitHub-only authentication
        //$events->attach('ZfcUser\Authentication\Adapter\AdapterChain', 'authenticate.pre', function($e) {
        //    foreach ($e->getTarget()->events()->getListeners('authenticate') as $listener) {
        //        $callback = $listener->getCallback();
        //        $e->getTarget()->events()->detach($listener);
        //    }
        //    $e->getTarget()->attach(new Authentication\Adapter\ZfcUserGithub);
        //});
    }*/
/*
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
 */
    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /*public function modulesLoaded($e)
    {
        $config = $e->getConfigListener()->getMergedConfig();
        static::$options = $config['edpgithub'];
    }*/

    /*public static function getOption($option)
    {
        if (!isset(static::$options[$option])) {
            return null;
        }
        return static::$options[$option];
    }*/
}
