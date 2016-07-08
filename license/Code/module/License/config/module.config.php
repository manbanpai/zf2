<?php
namespace License;

return array(
    'controllers' => array(
        'invokables' => array(
            'License\Controller\Lic' => 'License\Controller\LicController',
        )
    ),
    'router' => array(
        'routes' => array(
            'lic' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/lic[/:controller[/:action]]',
                    'constraints' => array(
                        'controller' => '[a-zA-z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'License\Controller',
                        'controller' => 'Lic',
                        'action'     => 'acl_index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        )
    )
);