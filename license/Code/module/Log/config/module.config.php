<?php
namespace Log;

return array(
		
	'controllers'=>array(
		'invokables'=>array(
			'Log\Controller\Log'=>'Log\Controller\LogController',
		),		
	),
	
	'controller_plugins'=>array(
		'invokables'=>array(
			'LogPlugin'=>'Log\Controller\Plugin\LogPlugin',		
		),		
	),
		
	'router'=>array(
		'routes'=>array(
			'log'=>array(
				'type'=>'Segment',
				'options'=>array(
					'route'=>'/log[/:controller[/:action[/:id][/:url][/:time][/:user]]]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+',
							
					),
					'defaults' => array(
						'__NAMESPACE__' => 'Log\Controller',
						'controller' => 'Log',
						'action'     => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type' => 'Segment',
						'options' => array(
							'route'    => '/[:controller[/:action[/:url][/:time][/:user]]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
								'url'     => '[a-zA-Z][a-zA-Z0-9_-/]*',
								'time'     => '[a-zA-Z0-9_-]*',
								'user'     => '[a-zA-Z0-9_-]*',
							),
							'defaults' => array(
							),
						),
					),
				),
			)		
		),		
	),
		
	'view_manager' => array(
		'template_path_stack' => array(
				__DIR__ . '/../view',
		),
	),
);