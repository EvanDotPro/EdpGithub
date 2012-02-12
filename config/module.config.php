<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'edpgithub'             => 'EdpGithub\Controller\GithubController',
                'edpgithub_write_db'    => 'Zend\Db\Adapter\DiPdoMysql',
                'edpgithub_read_db'     => 'edpgithub_write_db',
                'edpgithub_user_mapper' => 'EdpGithub\Mapper\UserGithubZendDb',
                'github'                => 'EdpGithub\Controller\GithubController',
            ),

            'edpgithub_write_db' => array(
                'parameters' => array(
                    'pdo'    => 'edpgithub_pdo',
                    'config' => array(),
                ),
            ),
            'EdpGithub\Mapper\UserGithubZendDb' => array(
                'parameters' => array(
                    'readAdapter'  => 'edpgithub_read_db',
                    'writeAdapter' => 'edpgithub_write_db',
                ),
            ),
            'ZfcUser\Authentication\Adapter\AdapterChain' => array(
                'parameters' => array(
                    'defaultAdapter' => 'EdpGithub\Authentication\Adapter\ZfcUserGithub',
                ),
            ),
            'EdpGithub\Authentication\Adapter\ZfcUserGithub' => array(
                'parameters' => array(
                    'mapper'        => 'edpgithub_user_mapper',
                    'userService'   => 'EdpGithub\ApiClient\Service\User',
                    'zfcUserMapper' => 'zfcuser_user_mapper',
                ),
            ),
            'EdpGithub\ApiClient\Service\AbstractService' => array(
                'parameters' => array(
                    'apiClient' => 'EdpGithub\ApiClient\ApiClient'
                ),
            ),
            'github' => array(
                'parameters' => array(
                    'emailForm' => 'EdpGithub\Form\EmailAddress',
                    'userMapper' => 'zfcuser_user_mapper', // @TODO use service layer
                ),
            ),
            'EdpGithub\Form\EmailAddress' => array(
                'parameters' => array(
                    'emailValidator' => 'zfcuser_uemail_validator',
                ),
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'edpgithub' => __DIR__ . '/../view',
                        ),
                    ),
                ),
            ),

            /**
             * Routes
             */

            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
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
            ),
        ),
    ),
);
