<?php

namespace EdpGithub\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

class Cache implements ListenerAggregateInterface, ServiceManagerAwareInterface
{
    /**
     * @var array
     */
    private $options;

    protected $listeners = array();

    protected $serviceManager;

    protected $cacheKey;

    protected $cache;

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('pre.send', array($this, 'preSend'), 1);
        $this->listeners[] = $events->attach('post.send', array($this, 'postSend'));
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function preSend(Event $e) {
        $request = $e->getTarget();

        $cache = $this->getCache();

        $this->cacheKey = md5($request);

        $response = $cache->getItem($this->cacheKey, $success);
        if($success) {
            $tags = $cache->getTags($this->cacheKey);
            $request->getHeaders()->addHeaders(array(
                'If-None-Match' => $tags[0],
            ));
        }
    }

    public function postSend(Event $e)
    {
        $response = $e->getTarget();

        $statusCode =  $response->getStatusCode();

        $cache = $this->getCache();

        if($statusCode == 304) {
            $response =  $cache->getItem($this->cacheKey);
        } else {
            $cache->setItem($this->cacheKey, $response);
            $headers = $response->getHeaders();
            $etag = $headers->get('Etag')->getFieldValue();
            $tags = array(
                'etag' => $etag,
            );
            $cache->setTags($this->cacheKey, $tags);
        }
        return $response;
    }

    public function getCache()
    {
        if($this->cache === null) {
            /* @var $config array */
            $config = $this->getServiceManager()->get('Config');
            /* @var $cache StorageInterface */
            $cache = $this->getServiceManager()->get('edpgithub.cache');

            $this->cache = $cache;
        }

        return $this->cache;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}
