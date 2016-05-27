<?php
namespace System;

return array(
    'controllers' => array(
        'invokables' => array(
            'System\Controller\Menu'=>'System\Controller\MenuController',
			'System\Controller\UserRole'=>'System\Controller\UserRoleController',
			'System\Controller\User'=>'System\Controller\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'system' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/system[/:controller[/:action[/:id]]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'System\Controller',
                        'controller' => 'User',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);