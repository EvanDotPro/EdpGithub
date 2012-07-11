<?php
return array(
    'router' => array(
        'routes' => array(
            'github' => array(
                'priority' => 1000,
                'type' => 'Literal',
                'options' => array(
                    'route' => '/github',
                    'defaults' => array(
                        'controller' => 'github',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'email' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/email',
                            'defaults' => array(
                                'controller' => 'github',
                                'action'     => 'email',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
