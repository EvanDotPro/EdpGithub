<?php

namespace EdpGithub;

use Buzz\Client\Curl;
use Buzz\Client\ClientInterface;

use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

use EdpGithub\HttpClient\HttpClient;
use EdpGithub\HttpClient\HttpClientInterface;
use EdpGithub\HttpClient\Listener\AuthListener;

class Client
{
    /**
     * Constant for authentication method. Indicates the default, but deprecated
     * login with username and token in URL.
     */
    const AUTH_URL_TOKEN = 'url_token';

    /**
     * Constant for authentication method. Not indicates the new login, but allows
     * usage of unauthenticated rate limited requests for given client_id + client_secret
     */
    const AUTH_URL_CLIENT_ID = 'url_client_id';

    /**
     * Constant for authentication method. Indicates the new favored login method
     * with username and password via HTTP Authentication.
     */
    const AUTH_HTTP_PASSWORD = 'http_password';

    /**
     * Constant for authentication method. Indicates the new login method with
     * with username and token via HTTP Authentication.
     */
    const AUTH_HTTP_TOKEN = 'http_token';

    /*
     * EventManager
     */
    protected $events;

    /**
     * @var array
     */
    private $options = array(
        'base_url'    => 'https://api.github.com/',
        'timeout'     => 10,
        'api_version' => 'beta',
    );

    /**
     * The Buzz instance used to communicate with GitHub
     *
     * @var HttpClient
     */
    private $httpClient;

    protected $serviceManager;

    public function __construct(EventManagerInterface $em, ServiceManager $serviceManager)
    {
        $this->setEventManager($em);
        $this->setserviceManager($serviceManager);

        $httpClient = new Curl();
        $httpClient->setTimeout($this->options['timeout']);
        $httpClient->setVerifyPeer(false);

        $this->httpClient = new HttpClient($this->options, $httpClient);

        $em = $this->getEventManager();
        $em->trigger('init', $this);
    }

    public function api($name)
    {
        $service = $this->serviceManager()->get('EdpGithub\Api\CurrentUser');
        $service->setClient($this);
    }

    /**
     * Authenticate a user for all next requests
     *
     * @param string      $tokenOrLogin  GitHub private token/username/client ID
     * @param null|string $password      GitHub password/secret
     * @param null|string $authMethod    One of the AUTH_* class constants
     */
    public function authenticate($tokenOrLogin, $password = null, $authMethod = null)
    {
        $sm = $this->getServiceManager();
        $authListener = $sm->get('EdpGithub\Listener\AuthListener');
        $authListener->setMethod($authMethod);
        $authListener->setOptions(
            array(
                'tokenOrLogin' => $tokenOrLogin,
                'password'     => $password
            )
        );

        $this->httpClient->addListener($authListener);
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $events;
        return $this;
    }

    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }
}