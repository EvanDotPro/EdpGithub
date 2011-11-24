<?php
return array(
    'routes' => array(
        'edpgithub' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/github',
                'defaults' => array(
                    'controller' => 'github',
                ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'auth' => array(
                    'type' => 'Literal',
                    'options' => array(
                        'route' => '/auth',
                        'defaults' => array(
                            'controller' => 'edpgithub',
                            'action'     => 'auth',
                        ),
                    ),
                ),
                'callback' => array(
                    'type' => 'Literal',
                    'options' => array(
                        'route' => '/callback',
                        'defaults' => array(
                            'controller' => 'edpgithub',
                            'action'     => 'callback',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'di' => array(
        'instance' => array(
            'alias' => array(
                'edpgithub' => 'EdpGithub\Controller\GithubController',
            ),
        ),
    ),
);
