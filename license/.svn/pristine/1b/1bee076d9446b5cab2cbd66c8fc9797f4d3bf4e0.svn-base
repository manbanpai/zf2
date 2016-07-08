<?php
namespace Ca;

return array(
    'controllers' => array(
        'invokables' => array(
            'Ca\Controller\Company' => 'Ca\Controller\CompanyController',
            'Ca\Controller\Cert'    => 'Ca\Controller\CertController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'ca' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/ca[/:controller[/:action[/:id]]][/:page]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Ca\Controller',
                        'controller' => 'Company',
                        'action'     => 'index',
                        'page' => 1,
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
