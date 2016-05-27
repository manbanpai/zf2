<?php
namespace System\Controller;

use System\Model\Menu;

use System\Form\MenuForm;

use Application\Components\Controller;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

class MenuController extends Controller
{
	protected $menuTable;
	protected $menuPermiTable;
	
	public function permiAction()
	{
		$request = $this->getRequest();
		if($request->isPost()){
			$permi = $request->getPost();
			$id = (int) $request->getPost('id');
			if($id){
				$operation = explode(',',$request->getPost('str'));
				$menuPermi = $this->getMenuPermiTable()->fetchAll(array('menu_id'=>$id));
				$tmp = array();
				if(!empty($menuPermi)){
					foreach($menuPermi as $m){
						if(!in_array($m->operation,$operation)){
							$this->getMenuPermiTable()->deleteMenuPermi($m->id);
						}else{
							$tmp[] = $m->operation;
						}
					}
					$operation = array_diff($operation,$tmp);
				}
				//print_r($operation);exit;
				if(!empty($operation)){
					$des = array(
							'add'=>'添加',
							'update'=>'修改',
							'delete'=>'删除',
							'export'=>'导出',
							'import'=>'导入',
							'statistics'=>'统计',
							'backup'=>'备份'
					);
					foreach($operation as $o){
						$s = explode('_', $o);
						if(!empty($s)){
							$k = $des[$s[1]];
						}
						$arr = array('menu_id'=>$id,'name'=>$k,'operation'=>strtolower($o));
						$this->getMenuPermiTable()->insertMenuPermi($arr);
					}
				}
				$this->redirect()->toRoute('system',array('controller'=>'menu'));
			}
		}
		
		$view = new ViewModel();
		$view->setTerminal(true);
		return $view;
	}
	
	public function deleteAction()
	{
		$id = (int)$this->params()->fromRoute('id',0);
		if(!$id){
			$this->redirect()->toRoute('system',array(
					'controller'=>'menu',
					'action'=>'index',
					));
		}
		
		$request = $this->getRequest();
		if($request->isGet()){
			$this->getMenuTable()->deleteMenu($id);
			$this->redirect()->toRoute('system',array(
					'controller'=>'menu',
					'action'=>'index',
					));
		}
	}
	
	public function addAction()
	{
		$form = new MenuForm();
		$form->get('submit')->setValue('Add');
		$this->setMenuList($form);
		
		$request = $this->getRequest();
		if($request->isPost()){
			$menu = new Menu();
			$form->setInputFilter($menu->getInputFilter());
			$form->setData($request->getPost());
		
			if($form->isValid()){
				$menu->exchangeArray($form->getData());
				if($request->getPost('url')){
					$url = explode('/', $request->getPost('url'));
					$menu->controller = $url[0];
				}
				$this->getMenuTable()->saveMenu($menu);
				return $this->redirect()->toRoute('system',array('controller'=>'menu'));
			}
		}
		
		$view = new ViewModel(array(
				'form'=>$form,
		));
		
		return $view;
	}
	
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id',0);
		
		if(!$id){
			return $this->redirect()->toRoute('system',array('controller'=>'menu'));
		}
		
		try {
			$menu = $this->getMenuTable()->getMenu($id);
		} catch (\Exception $ex) {
			return $this->redirect()->toRoute('system',array('controller'=>'menu'));
		}
		
		$form = new MenuForm();
		$form->bind($menu);
		$form->get('submit')->setValue('Edit');
		$data = $this->getMenuTable()->fetchAll();
		$this->setMenuList($form);
		
		$request = $this->getRequest();
		if($request->isPost()){
			$form->setInputFilter($menu->getInputFilter());
			$form->setData($request->getPost());
			
			if($form->isValid()){
				
				if($request->getPost('url')){
					$url = explode('/', $request->getPost('url'));
					$menu->controller = $url[0];
				}
				$this->getMenuTable()->saveMenu($menu);
				
				return $this->redirect()->toRoute('system',array('controller'=>'menu'));
			}
		}
		
		$view = new ViewModel(array(
				'id'=>$id,
				'form'=>$form,
				));
		
		return $view;
	}

	public function indexAction()
	{
		$paginator = $this->getMenuTable()->fetchAll();
		
		//模态框
		$per = $this->getMenuPermiTable()->fetchAll();
		$permi = array();
		foreach($per as $p){
			$permi[] = $p->operation;
		}
		
		$view = new ViewModel(array(
				'paginator'=>$paginator,
				'permi'=>$permi,
				));
		return $view;
	}
	
	public function setMenuList($form)
	{
		$data = $this->getMenuTable()->fetchAll();
		$arr = array();
		foreach($data as $d){
			$arr[$d->id] = $d->name;
		}
	
		$form->get('pid')->setValueOptions($arr);
	}
	
	public function getMenuPermiTable()
	{
		if(!$this->menuPermiTable){
			$sm = $this->getServiceLocator();
			$this->menuPermiTable = $sm->get('System\Model\MenuPermiTable');
		}
		return $this->menuPermiTable;
	}
	
	public function getMenuTable(){
		if(!$this->menuTable){
			$sm = $this->getServiceLocator();
			$this->menuTable = $sm->get('System\Model\MenuTable');
		}
		return $this->menuTable;
	}
}