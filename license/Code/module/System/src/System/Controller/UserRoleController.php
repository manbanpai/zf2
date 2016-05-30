<?php
namespace System\Controller;

use Application\Components\Controller;

use System\Form\UserRoleForm;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

use System\Model\UserRole;

use System\Model\UserRoleTable;

class UserRoleController extends AbstractActionController 
{
	protected $userRoleTable;
	protected $menuTable;
	protected $menuPermiTable;
	protected $userTable;
	
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id',0);
		
		if(!$id){
			return $this->redirect()->toRoute('system',array('controller'=>'userrole','action'=>'add'));
		}
		
		try {
			$userRole = $this->getUserRoleTable()->getUserRole($id);
		} catch (\Exception $ex) {
			return $this->redirect()->toRoute('system',array('controller'=>'userrole'));
		}
		
		$form = new UserRoleForm();
		$form->bind($userRole);
		$form->get('submit')->setValue('Edit');
		$value = $this->getMenuTable()->fetchAll(array(
				'where'=>array('display'=>'Y'),
				));
		$permi = $this->getMenuPermiTable()->fetchAll();
		$permiss = array();
		foreach($permi as $p){
			$permiss[] = $p;
		}
		
		$time = $userRole->createtime;
		$request = $this->getRequest();
	
		if($request->isPost()){
			$form->setInputFilter($userRole->getInputFilter());
			$acl = $request->getPost('acl');
			$form->setData($request->getPost());

			if($form->isValid()){
				$userRole->acl = ','.implode(',',$acl).',';
				$userRole->createtime = $time;
				$this->getUserRoleTable()->saveUserRole($userRole);
				return $this->redirect()->toRoute('system',array('controller'=>'userrole'));
			}
		}
		$view = new ViewModel(array(
				'id'=>$id,
				'form'=>$form,
				'value'=>$value,
				'permi'=>$permiss,
				'acl'=>explode(',',$userRole->acl),
		));
		return $view;
	}
	
	public function addAction()
	{
		$form = new UserRoleForm();
		$form->get('submit')->setValue('Add');
		$value = $this->getMenuTable()->fetchAll(array(
				'where'=>array('display'=>'Y'),
				));
		$permi = $this->getMenuPermiTable()->fetchAll();
		$permiss = array();
		foreach($permi as $p){
			$permiss[] = $p;
		}
		
		$request = $this->getRequest();
		if($request->isPost()){
			$userRole = new UserRole();
			$form->setInputFilter($userRole->getInputFilter());
			$form->setData($request->getPost());
			$acl = $request->getPost('acl');
			
			if($form->isValid()){
				$userRole->exchangeArray($form->getData());
				$userRole->createtime = time();
				$userRole->acl = ','.implode(',',$acl).',';
				$this->getUserRoleTable()->saveUserRole($userRole);
				return $this->redirect()->toRoute('system',array('controller'=>'userrole'));
			}
		}
		$view = new ViewModel(array(
				'form'=>$form,
				'value'=>$value,
				'permi'=>$permiss,
				));
		return $view;
	}
	
	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id',0);
		if(!$id){
			return $this->redirect()->toRoute('system',array('controller'=>'userrole'));
		}
		
		$request = $this->getRequest();
		if($request->isGet()){
			$this->getUserRoleTable()->deleteUserRole($id);
			$this->redirect()->toRoute('system',array('controller'=>'userrole'));
		}
	}
	
	public function indexAction(){

		$paginator = $this->getUserRoleTable()->fetchAll(array(
				'paginated'=>true,
				'order'=>'id desc',
				));
		$paginator->setCurrentPageNumber($this->params()->fromQuery('page',1));
		$paginator->setItemCountPerPage(5);
		$count = array();
		foreach ($paginator as $p){
			$arr = $this->getUserTable()->fetchAll(array(
				'where'=>array('role_id'=>(int)$p->id),	
				));
			$count[$p->id] = count($arr);
		}
		
		$view = new ViewModel(array(
				'paginator'=>$paginator,
				'count'=>$count,
				));
		return $view;
	}
	
	public function getUserTable()
	{
		if(!$this->userTable){
			$sm = $this->getServiceLocator();
			$this->userTable = $sm->get('System\Model\UserTable');
		}
		return $this->userTable;
	}
	
	public function getMenuPermiTable()
	{
		if(!$this->menuPermiTable){
			$sm = $this->getServiceLocator();
			$this->menuPermiTable = $sm->get('System\Model\MenuPermiTable');
		}
		return $this->menuPermiTable;
	}
	
	public function getMenuTable()
	{
		if(!$this->menuTable){
			$sm = $this->getServiceLocator();
			$this->menuTable = $sm->get('System\Model\MenuTable');
		}
		return $this->menuTable;
	}
	
	public function getUserRoleTable()
	{
		if(!$this->userRoleTable){
			$sm = $this->getServiceLocator();
			$this->userRoleTable = $sm->get('System\Model\UserRoleTable');
		}
		return $this->userRoleTable;
	}
}