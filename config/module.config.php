<?php
return array(
    'service_manager' => array(
        'invokables' => array(
            'EdpGithub\Listener\AuthListener' => 'EdpGithub\HttpClient\Listener\AuthListener',
        ),
    ),
);