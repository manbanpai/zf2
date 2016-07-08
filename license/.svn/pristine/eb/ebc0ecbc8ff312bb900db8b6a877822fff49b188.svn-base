<?php
namespace System;

use System\Model\MenuPermiTable;

use System\Model\MenuPermi;

use System\Model\MenuTable;

use System\Model\Menu;

use System\Model\UserRoleTable;

use System\Model\UserRole;

use System\Model\User;

use System\Model\UserTable;

use Zend\Mvc\ModuleRouteListener;

use Zend\Mvc\MvcEvent;

use Zend\Db\ResultSet\ResultSet;

use Zend\Db\TableGateway\TableGateway;

class Module{
	
	//引导程序
	public function onBootstrap(MvcEvent $e){
		
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}
	
	//加载模块配置文件
	public function getConfig(){
		return include __DIR__.'/config/module.config.php';
	}
	
	//此模块中自动加载配置信息
	public function getAutoloaderConfig(){
		return array(
			'Zend\Loader\StandardAutoloader'=>array(
				'namespaces'=>array(
					__NAMESPACE__=>__DIR__.'/src/'.__NAMESPACE__,
				    'Common'=>__DIR__.'/../../vendor/common/src',
				)
			)
		);
	}
	
	public function getServiceConfig(){
		return array(
			'factories'=>array(
				'System\Model\MenuPermiTable'=>function($sm){
					$tg = $sm->get('MenuPermiGateway');
					$table = new MenuPermiTable($tg);
					return $table;
				},
				'MenuPermiGateway'=>function($sm){
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$rs = new ResultSet();
					$rs->setArrayObjectPrototype(new MenuPermi());
					return new TableGateway('lic_user_permi', $adapter,null,$rs);
				},
				'System\Model\MenuTable'=>function($sm){
					$tg = $sm->get('MenuGateway');
					$table = new MenuTable($tg);
					return $table;
				},	
				'MenuGateway'=>function($sm){
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$rs = new ResultSet();
					$rs->setArrayObjectPrototype(new Menu());
					return new TableGateway('lic_user_menu', $adapter,null,$rs);
				},
				'System\Model\UserRoleTable'=>function($sm){
					$tg = $sm->get('UserRoleGateway');
					$table = new UserRoleTable($tg);
					return $table;
				},
				'UserRoleGateway'=>function($sm){
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$rs = new ResultSet();
					$rs->setArrayObjectPrototype(new UserRole());
					return new TableGateway('lic_user_role', $adapter,null,$rs);
				},
				'System\Model\UserTable'=>function($sm){
					$tg = $sm->get('UserGateway');
					$table = new UserTable($tg);
					return $table;
				},
				'UserGateway'=>function($sm){
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$rs = new ResultSet();
					$rs->setArrayObjectPrototype(new User());
					return new TableGateway('lic_user', $adapter,null,$rs);
				},
			),
		);
	}
}