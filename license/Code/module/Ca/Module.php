<?php
namespace Ca;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Ca\Model\CompanyTable;
use Ca\Model\Company;
use Ca\Model\AreaTable;
use Ca\Model\Area;

class Module implements ServiceProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Ca\Model\CompanyTable' => function($sm){
                    $tableGateway = $sm->get('CompanyTableGateway');
                    return new CompanyTable($tableGateway);
                },
                'CompanyTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Company());
                    return new TableGateway('lic_company', $dbAdapter, null, $resultSetPrototype);
                },
                'Ca\Model\AreaTable' => function ($sm) {
                    $tableGateway = $sm->get('AreaTableGateway');
                    return new AreaTable($tableGateway);
                },
                'AreaTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Area());
                    return new TableGateway('lic_area', $dbAdapter, null, $resultSetPrototype);
                }
            )
        );
    }
}