<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'edpgithub_zend_db_adapter' => 'Zend\Db\Adapter\Adapter',
                'edpgithub'                 => 'EdpGithub\Controller\GithubController',
                'edpgithub_user_mapper'     => 'EdpGithub\Mapper\UserGithubZendDb',
                'edpgithub_github_tg'       => 'Zend\Db\TableGateway\TableGateway',
                'github'                    => 'EdpGithub\Controller\GithubController',
            ),
            'EdpGithub\Mapper\UserGithubZendDb' => array(
                'parameters' => array(
                    'tableGateway' => 'edpgithub_github_tg',
                ),
            ),
            'edpgithub_github_tg' => array(
                'parameters' => array(
                    'tableName' => 'user_github',
                    'adapter'   => 'edpgithub_zend_db_adapter',
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
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths' => array(
                        'edpgithub' => __DIR__ . '/../view',
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
