<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    // 表示数据库配置信息节点
	'db'=>array(
		'driver'=>'Pdo',//表示数据库使用的驱动程序类型
		'dsn'=>'mysql:dbname=license_db;host=localhost',//数据库连接串,也称为数据源
		//数据库驱动选项
		'driver_options'=>array(
				PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES \'UTF8\''
				),	
			),
	//表示服务器管理器节点
	'service_manager'=>array(
		//表示服务器管理器需要加载的工厂类
		'factories'=>array(
				'Zend\Db\Adapter\Adapter'=>'Zend\Db\Adapter\AdapterServiceFactory',
				),	
			),
	'session' => array(
			'config' => array(
					'class' => 'Zend\Session\Config\SessionConfig',
					'options' => array(
							'name' => 'license',
					),
			),
			'storage' => 'Zend\Session\Storage\SessionArrayStorage',
			'validators' => array(
					'Zend\Session\Validator\RemoteAddr',
					'Zend\Session\Validator\HttpUserAgent',
			),
	),
);
