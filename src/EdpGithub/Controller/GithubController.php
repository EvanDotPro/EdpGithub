<?php

namespace EdpGithub\Controller;

use Zend\Mvc\Controller\ActionController,
    EdpGithub\Module,
    Zend\Http\ClientStatic;

class GithubController extends ActionController
{
    public function authAction()
    {
        $params = array('client_id' => Module::getOption('github_client_id'));
        if (Module::getOption('github_callback_url')) {
            $params['redirect_uri'] = Module::getOption('github_callback_url');
        }
        $queryString = http_build_query($params);
        $url = 'https://github.com/login/oauth/authorize?' . $queryString;
        return $this->redirect()->toUrl($url);
    }

    public function callbackAction()
    {
        $url = 'https://github.com/login/oauth/access_token';
        $params = array(
            'client_id'     => Module::getOption('github_client_id'),
            'client_secret' => Module::getOption('github_client_secret'),
            'code'          => $this->getRequest()->query()->get('code'),
        );

        $content = ClientStatic::post($url, $params)->getContent();
        parse_str($content, $response);

        $this->events()->trigger('github.auth', array('response' => $response));
        var_dump($response);
        die();
    }
}
