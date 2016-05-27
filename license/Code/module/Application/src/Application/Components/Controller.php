<?php
namespace Application\Components;

use Zend\EventManager\EventManagerInterface;

use Zend\Session\Container;

use Zend\Mvc\Controller\AbstractActionController;

class Controller extends AbstractActionController
{
	public $_adminUserId;
	public $_adminUserName;
	public $_adminRoleId;
	public $session;
	public $adapter;
	public $func;
	
	public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            $request = $e->getRequest();
            $method  = $request->getMethod();
            if (!in_array($method, array('PUT', 'DELETE', 'PATCH'))) {
                // nothing to do
                return;
            }

            if ($controller->params()->fromRoute('id', false)) {
                // nothing to do
                return;
            }

            // Missing identifier! Redirect.
            return $controller->redirect()->toRoute(/* ... */);
        }, 100); // execute before executing action logic
        $this->init();
    }
	
	public function init()
	{
		$session = new Container('login');
		$this->session = $session;
		$this->_adminRoleId = $session->offsetGet('_adminRoleId');
		$this->_adminUserId = $session->offsetGet('_adminUserId');
		$this->_adminUserName = $session->offsetGet('_adminUserName');
		if($this->_adminRoleId == null || $this->_adminUserId ==null){
			$session->offsetUnset('_adminRoleId');
			$session->offsetUnset('_adminUserId');
			return $this->redirect()->toRoute('login',array('action'=>'index'));
		}
		$sm = $this->getServiceLocator();
		$this->adapter = $sm->get('Zend\Db\Adapter\Adapter');
	}
}