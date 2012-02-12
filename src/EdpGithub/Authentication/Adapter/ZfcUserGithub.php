<?php

namespace EdpGithub\Authentication\Adapter;

use ZfcUser\Authentication\Adapter\AbstractAdapter,
    ZfcUser\Authentication\Adapter\AdapterChainEvent as AuthEvent,
    ZfcUser\Module as ZfcUser,
    EdpGithub\Module as EdpGithub,
    EdpGithub\ApiClient\ApiClient,
    Zend\Authentication\Result as AuthenticationResult,
    Zend\Http\ClientStatic,
    Zend\Http\PhpEnvironment\Response;


class ZfcUserGithub extends AbstractAdapter
{
    protected $userService;

    protected $mapper;

    protected $zfcUserMapper;

    public function authenticate(AuthEvent $e)
    {
        $this->getStorage()->clear();
        if ($this->isSatisfied()) return;

        $request = $e->getRequest();

        if ($request->query()->get('error')) {
            $this->setSatisfied(false);
            $e->setIdentity(null);
            return false;
        }

        if (!$request->query()->get('code')) {
            $params = array('client_id' => EdpGithub::getOption('github_client_id'));

            if (EdpGithub::getOption('github_callback_url')) {
                $params['redirect_uri'] = EdpGithub::getOption('github_callback_url');
            }

            $queryString = http_build_query($params);
            $url = 'https://github.com/login/oauth/authorize?' . $queryString;

            $e->setIdentity(null);
            $response = new Response();
            $response->headers()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            return $response;
        }
        
        if (!$token = $this->validateCallbackCode($request->query()->get('code'))) {
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
            $userModelClass = ZfcUser::getOption('user_model_class');
            $localUser = new $userModelClass;
            $localUser->setUsername($user->getLogin());
            $localUser->setEmail($user->getEmail() ?: $user->getLogin() . '@github.com');
            $localUser->setPassword('github');
            $localUser->setDisplayName($user->getName() ?: $user->getLogin());
            $localUser = $this->getZfcUserMapper()->persist($localUser);
            $this->getMapper()->linkUserToGithubId($localUser->getUserId(), $githubId);
            var_dump($localUser->getUserId().'asd');
            // add github linker
        }
        $e->setIdentity($localUser->getUserId());

        //$userService = new \EdpGithub\ApiClient\Service\User;
        //$userService->setApiClient($client);
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
            'client_id'     => EdpGithub::getOption('github_client_id'),
            'client_secret' => EdpGithub::getOption('github_client_secret'),
            'code'          => $code,
        );

        $content = ClientStatic::post($url, $params)->getContent();
        parse_str($content, $response);

        if (isset($response['access_token']) 
            && isset($response['token_type']) 
            && ('bearer' === $response['token_type'])
        ) {
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
}
