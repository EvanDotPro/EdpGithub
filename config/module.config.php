<?php
return array(
    'service_manager' => array(
        'invokables' => array(
            'EdpGithub\Client'      => 'EdpGithub\Client',
            'EdpGithub\CurrentUser' => 'EdpGithub\Api\CurrentUser',
            'EdpGithub\User'        => 'EdpGithub\Api\User',
            'EdpGithub\Repos'       => 'EdpGithub\Api\Repos',
            'EdpGithub\Gist'        => 'EdpGithub\Api\Gist',
            'EdpGithub\GitData'     => 'EdpGithub\Api\GitData',
            'EdpGithub\Organization'=> 'EdpGithub\Api\Organization',
            'EdpGithub\PullRequest' => 'EdpGithub\Api\PullRequest',
            'EdpGithub\Repository'  => 'EdpGithub\Api\Repository',
            'EdpGithub\Issue'       => 'EdpGithub\Api\Issue',
            'EdpGithub\Listener\AuthListener' => 'EdpGithub\Listener\AuthListener',
        ),
    ),
);