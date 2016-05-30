<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\I18n\Filter\NumberFormat;

use Zend\Db\Sql\Sql;

use Zend\Db\TableGateway\TableGateway;

use Application\Components\Controller;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\Session\Container;

class IndexController extends AbstractActionController
{
	public $menuTable;
	public $userTable;
	
	protected $container;
	
	private function getContainer()
	{
		if (!$this->container) {
			$this->container = new Container('login');
		}
		return $this->container;
	}
	
	public function welcomeAction()
	{
		//$filter = new NumberFormat("de_DE");
		
		$user = $this->select('lic_user',null,'id desc',5);
		
		$userConut = $this->select('lic_user');
		//echo $filter->filter(1234567.8912346);
		
		$view = new ViewModel(array(
			'user'=>$user,
			'userCount'=>count($userConut),	
			));
		return $view;
	}
	
    public function indexAction()
    {
    	$data = $this->select('lic_user_menu', array('display'=>'Y'));
    	
    	$sess = $this->getContainer();
    	
    	if($sess->offsetExists('_adminUserName')){
    		$_adminUserName = $sess->offsetGet('_adminUserName');
    	}
    	
    	if($sess->offsetExists('_adminUserId')){
    		$_adminUserId = $sess->offsetGet('_adminUserId');
    	}else{
    		return $this->redirect()->toRoute('application');
    	}
    	
    	if($sess->offsetExists('_adminRoleId')){
    		$_adminRoleId = $sess->offsetGet('_adminRoleId');
    	}else{
    		return $this->redirect()->toRoute('application');
    	}
    	
        $view = new ViewModel();
        $view->setTerminal('true');
        $variables = array(
        		'data'=>$data,
        		'username'=>$_adminUserName,
        		'id'=>$_adminUserName,
        		);
        $view->setVariables($variables);

        return $view;
    }
    
	public function select($table,$where=null,$order=null,$limit=null)
	{
		if($table){
			$sql = new Sql($this->getAdapter());
			$select = $sql->select();
			$select->from($table);
			if($where != null)
				$select->where($where);
			if($order != null)
				$select->order($order);
			if($limit != null)
				$select->limit($limit);
			$statement = $sql->prepareStatementForSqlObject($select);
			$results = $statement->execute();
			
			return $results;
		}
	}
	
	public function getAdapter()
	{
		$sm = $this->getServiceLocator();
		return $sm->get('Zend\Db\Adapter\Adapter');
	}
}
