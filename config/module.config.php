<?php
return array(
    'service_manager' => array(
        'invokables' => array(
            'EdpGithub\Client'      => 'EdpGithub\Client',
            'EdpGithub\Api\CurrentUser' => 'EdpGithub\Api\CurrentUser',
            'EdpGithub\Api\User'        => 'EdpGithub\Api\User',
            'EdpGithub\Api\Repos'       => 'EdpGithub\Api\Repos',
            'EdpGithub\Api\Gist'        => 'EdpGithub\Api\Gist',
            'EdpGithub\Api\GitData'     => 'EdpGithub\Api\GitData',
            'EdpGithub\Api\Organization'=> 'EdpGithub\Api\Organization',
            'EdpGithub\Api\PullRequest' => 'EdpGithub\Api\PullRequest',
            'EdpGithub\Api\Repository'  => 'EdpGithub\Api\Repository',
            'EdpGithub\Api\Issue'       => 'EdpGithub\Api\Issue',
            'EdpGithub\Listener\Auth\HttpPassword' => 'EdpGithub\Listener\Auth\HttpPassword',
            'EdpGithub\Listener\Auth\HttpToken' => 'EdpGithub\Listener\Auth\HttpToken',
            'EdpGithub\Listener\Auth\UrlClientId' => 'EdpGithub\Listener\Auth\UrlClientId',
            'EdpGithub\Listener\Auth\UrlToken' => 'EdpGithub\Listener\Auth\UrlToken',
            'EdpGithub\Listener\Error' => 'EdpGithub\Listener\Error',
            'EdpGithub\HttpClient' => 'EdpGithub\Http\Client',
        ),
    ),
);
