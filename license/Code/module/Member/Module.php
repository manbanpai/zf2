<?php
namespace Member;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Member\Model\MemberCompanyTable;
use Member\Model\MemberCompany;
use Member\Model\AreaTable;
use Member\Model\Area;
use Member\Model\LicenseTable;
use Member\Model\License;
use Member\Model\CertficateTable;
use Member\Model\Certficate;

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
                    'Common' => __DIR__ .'/../../vendor/common/src',
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Member\Model\MemberCompanyTable' => function($sm){
                    $tableGateway = $sm->get('MemberCompanyTableGateway');
                    return new MemberCompanyTable($tableGateway);
                },
                'MemberCompanyTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new MemberCompany());
                    return new TableGateway('lic_member_company', $dbAdapter, null, $resultSetPrototype);
                },
                'Member\Model\AreaTable' => function($sm){
                    $tableGateway = $sm->get('AreaTableGateway');
                    return new AreaTable($tableGateway);
                },
                'AreaTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Area());
                    return new TableGateway('lic_area', $dbAdapter, null, $resultSetPrototype);
                },
                'Member\Model\LicenseTable' => function($sm){
                    $tableGateway = $sm->get('LicenseTableGateway');
                    return new LicenseTable($tableGateway);
                },
                'LicenseTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new License());
                    return new TableGateway('lic_license', $dbAdapter, null, $resultSetPrototype);
                },
                'Member\Model\CertficateTable' => function($sm){
                    $tableGateway = $sm->get('CertficateTableGateway');
                    return new CertficateTable($tableGateway);
                },
                'CertficateTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Certficate());
                    return new TableGateway('lic_certficate', $dbAdapter, null, $resultSetPrototype);
                }
            )
        );
    }
}