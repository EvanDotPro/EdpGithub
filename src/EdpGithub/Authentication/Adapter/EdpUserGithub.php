<?php

namespace EdpGithub\Authentication\Adapter;

use ZfcUser\Authentication\Adapter\AbstractAdapter,
    ZfcUser\Authentication\Adapter\AdapterChainEvent as AuthEvent,
    EdpGithub\Module as EdpGithub,
    EdpGithub\ApiClient\ApiClient,
    Zend\Http\ClientStatic,
    Zend\Http\PhpEnvironment\Response;


class EdpUserGithub extends AbstractAdapter
{
    public function authenticate(AuthEvent $e)
    {
        $this->getStorage()->clear();
        if ($this->isSatisfied()) return;

        $request = $e->getRequest();

        if ($request->query()->get('error')) {
            $this->setSatisfied(false);
            $e->setIdentity(null);
            return false;
        } elseif ($request->query()->get('code')) {
            if (!$this->validateCallbackCode($request->query()->get('code'))) {
                $this->setSatisfied(false);
                $e->setIdentity(null);
                return false;
            }
            $this->setSatisfied(true);
            return true;
        }

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

            $client = new \EdpGithub\ApiClient\ApiClient;
            $client->setOauthToken($token);
            $userService = new \EdpGithub\ApiClient\Service\User;
            $userService->setApiClient($client);
            //var_dump($userService->get());
            //die('WE DID IT!');

            return true;
        }
        return false;
    }
}
