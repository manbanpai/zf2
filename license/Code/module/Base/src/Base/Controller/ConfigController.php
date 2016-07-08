<?php
namespace Base\Controller;

use Base\Model\Config;

use Base\Form\ConfigForm;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

class ConfigController extends AbstractActionController
{
	protected $configTable;
	
	//编辑
	public function editAction()
	{
		$vari = $this->params()->fromRoute('vari','');
		
		if($vari == ''){
			return $this->redirect()->toRoute('base',array('controller'=>'config','action'=>'add'));
		}
		
		try {
			$config = $this->getConfigTable()->getConfig($vari);
		} catch (\Exception $ex) {
			return $this->redirect()->toRoute('base',array('controller'=>'config','action'=>'add'));
		}
		
		$form = new ConfigForm();
		$form->bind($config);
		
		$request = $this->getRequest();
		if($request->isPost()){
			$form->setData($request->getPost());
			if($form->isValid()){
				$this->getConfigTable()->saveConfig($config);
				return $this->redirect()->toRoute('base',array('controller'=>'config','action'=>'index'));
			}
		}
		
		$view = new ViewModel(array(
				'form'=>$form,
				'vari'=>$vari,	
			));
		return $view;
	}
	
	//录入
	public function addAction()
	{
		$form = new ConfigForm();
		
		$request = $this->getRequest();
		if($request->isPost()){
			$config = new Config();
			$form->setData($request->getPost());
			$form->setInputFilter($config->getInputFilter());
			if($form->isValid()){
				$config->exchangeArray($form->getData());
				$this->getConfigTable()->saveConfig($config);
				return $this->redirect()->toRoute('base',array('controller'=>'config'));
			}
		}
		
		$view = new ViewModel(array(
			'form'=>$form,	
			));
		return $view;
	}
	
	//删除
	public function deleteAction()
	{
		$vari = $this->params()->fromRoute('vari','');
		
		if($vari == '')
			return $this->redirect()->toRoute('base',array('controller'=>'config'));
		
		$this->getConfigTable()->deleteConfig($vari);
		$this->redirect()->toRoute('base',array('controller'=>'config'));
		
	}
	
	//列表
	public function indexAction()
	{
		$base = $this->getConfigTable()->fetchAll(array(
				'where'=>array('scope'=>'base'),
				));
		
		$upload = $this->getConfigTable()->fetchAll(array(
				'where'=>array('scope'=>'upload'),
				));
		
		$others = $this->getConfigTable()->fetchAll(array(
				'where'=>array('scope'=>'others'),
				));
		
		$view = new ViewModel(array(
			'base'=>$base,	
			'upload'=>$upload,
			'others'=>$others
			));
		return $view;
	}
	
	public function getConfigTable()
	{
		if(!$this->configTable){
			$sm = $this->getServiceLocator();
			$this->configTable = $sm->get('Base\Model\ConfigTable');
		}
		return $this->configTable;
	}
}