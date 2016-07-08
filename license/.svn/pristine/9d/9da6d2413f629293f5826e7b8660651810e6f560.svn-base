<?php
namespace Log;

use Log\Model\LogTable;

use Zend\Db\TableGateway\TableGateway;

use Log\Model\Log;

use Zend\Db\ResultSet\ResultSet;

use Zend\Mvc\ModuleRouteListener;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent,
	Zend\ModuleManager\Feature\AutoloaderProviderInterface,
	Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$eventManager = $e->getApplication()->getEventManager();
		$eventManager->attach('route', array($this, 'loadConfiguration'), 2);
	}
	
	public function loadConfiguration(MvcEvent $e)
	{
		$application   = $e->getApplication();
		$sm            = $application->getServiceManager();
		$sharedManager = $application->getEventManager()->getSharedManager();
	
		$router = $sm->get('router');
		$request = $sm->get('request');
	
		$matchedRoute = $router->match($request);
	
		if (null !== $matchedRoute) {
			$sharedManager->attach('Zend\Mvc\Controller\AbstractActionController','dispatch',
					function($e) use ($sm) {
				$sm->get('ControllerPluginManager')->get('LogPlugin')
				->doWriterLog($e,$sm); //pass to the plugin...
			},2
			);
		}
	}
	
	/*
	 *  添加当前模块的初始化函数
	*  详见：<a href="http://blog.evan.pro/module-specific-layouts-in-zend-framework-2">http://blog.evan.pro/module-specific-layouts-in-zend-framework-2</a>
	*/
	public function init(ModuleManager $moduleManager)
	{
		$sharedEvents = $moduleManager->getEventManager()->getSharedManager();
		$sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
			// This event will only be fired when an ActionController under the MyModule namespace is dispatched.
			$controller = $e->getTarget();
			//$controller->layout('layout/zfcommons'); // points to module/Album/view/layout/album.phtml
		}, 100);
	}
	
	public function getConfig()
	{
		return include __DIR__.'/config/module.config.php';
	}
	
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader'=>array(
				'namespaces'=>array(
					__NAMESPACE__=>__DIR__.'/src/'.__NAMESPACE__,
					)	
				)	
			);
	}
	
	public function getServiceConfig()
	{
		return array(
			'factories'=>array(
				'Log\Model\LogTable'=>function($sm){
					$tg = $sm->get('logGateway');
					$table = new LogTable($tg);
					return $table;
				},
				'logGateway'=>function($sm){
					$adapter = $sm->get('Zend\Db\Adapter\Adapter');
					$rs = new ResultSet();
					$rs->setArrayObjectPrototype(new Log());
					return new TableGateway('lic_log', $adapter,null,$rs);
				},		
			)		
		);
	}
}