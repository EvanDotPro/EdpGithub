<?php

namespace EdpGithub\Authentication\Adapter;

use ZfcUser\Authentication\Adapter\AbstractAdapter,
    ZfcUser\Options\UserServiceOptionsInterface,
    ZfcUser\Authentication\Adapter\AdapterChainEvent as AuthEvent,
    ZfcUser\Module as ZfcUser,
    EdpGithub\Module as EdpGithub,
    EdpGithub\ApiClient\ApiClient,
    Zend\Authentication\Result as AuthenticationResult,
    Zend\Http\ClientStatic,
    Zend\Http\PhpEnvironment\Response,
    DateTime;


class ZfcUserGithub extends AbstractAdapter
{
    protected $userService;

    protected $mapper;

    protected $zfcUserMapper;

    protected $zfcUserOptions;

    public function authenticate(AuthEvent $e)
    {
        $this->getStorage()->clear();
        if ($this->isSatisfied()) return;

        $request = $e->getRequest();

        if ($request->getQuery()->get('error')) {
            $this->setSatisfied(false);
            $e->setIdentity(null);
            return false;
        }

        if (!$request->getQuery()->get('code')) {
            $params = array('client_id' => $this->getOptions()->getGithubClientId());

            if ($this->getOptions()->getGithubCallbackUrl()) {
                $params['redirect_uri'] = $this->getOptions()->getGithubCallbackUrl();
            }

            $queryString = http_build_query($params);
            $url = 'https://github.com/login/oauth/authorize?' . $queryString;

            $e->setIdentity(null);
            $response = new Response();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            return $response;
        }

        if (!$token = $this->validateCallbackCode($request->getQuery()->get('code'))) {
            $this->setSatisfied(false);
            $e->setIdentity(null);
            return false;
        }

        $userService = $this->getUserService();
        $apiClient = $userService->getApiClient();
        $apiClient->setOauthToken($token);
        $user = $userService->get();

        $githubId = $user->getId();

        if (!$localUser = $this->getMapper()->findUserByGithubId($githubId)) {
            $entityClass = $this->getZfcUserOptions()->getUserEntityClass();
            $localUser = new $entityClass;
            $localUser->setUsername($user->getLogin())
                      ->setEmail($user->getEmail() ?: $user->getLogin() . '@github.com')
                      ->setPassword('github')
                      ->setDisplayName($user->getName() ?: $user->getLogin());
            $this->getZfcUserMapper()->insert($localUser);
            $this->getMapper()->linkUserToGithubId($localUser->getId(), $githubId);
        }
        $e->setIdentity($localUser->getId());

        $storage = $this->getStorage()->read();
        $storage['identity'] = $e->getIdentity();
        $this->getStorage()->write($storage);
        $e->setCode(AuthenticationResult::SUCCESS)
          ->setMessages(array('Authentication successful.'));

        $this->setSatisfied(true);
        return true;
    }

    protected function validateCallbackCode($code)
    {
        $url = 'https://github.com/login/oauth/access_token';

        $params = array(
            'client_id'     => $this->getOptions()->getGithubClientId(),
            'client_secret' => $this->getOptions()->getGithubClientSecret(),
            'code'          => $code,
        );

        $content = ClientStatic::post($url, $params)->getContent();
        parse_str($content, $response);

        if (isset($response['access_token'])) {
            $token = $response['access_token'];
            return $token;
        }
        return false;
    }

    /**
     * Get userService.
     *
     * @return userService
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * Set userService.
     *
     * @param $userService the value to be set
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
        return $this;
    }

    /**
     * Get mapper.
     *
     * @return mapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * Set mapper.
     *
     * @param $mapper the value to be set
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * Get zfcUserMapper.
     *
     * @return zfcUserMapper
     */
    public function getZfcUserMapper()
    {
        return $this->zfcUserMapper;
    }

    /**
     * Set zfcUserMapper.
     *
     * @param $zfcUserMapper the value to be set
     */
    public function setZfcUserMapper($zfcUserMapper)
    {
        $this->zfcUserMapper = $zfcUserMapper;
        return $this;
    }

    public function getZfcUserOptions()
    {
        return $this->zfcUserOptions;
    }

    public function setZfcUserOptions(UserServiceOptionsInterface $zfcUserOptions)
    {
        $this->zfcUserOptions = $zfcUserOptions;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}
