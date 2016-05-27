<?php
namespace System\Model;

use Zend\InputFilter\InputFilter;

use Zend\InputFilter\InputFilterInterface;

use Zend\InputFilter\InputFilterAwareInterface;

class Menu implements InputFilterAwareInterface
{
	public $id;
	public $pid;
	public $name;
	public $module;
	public $controller;
	public $url;
	public $acl;
	public $sorting;
	public $display;
	
	public $inputFilter;
	
	public function exchangeArray($data)
	{
		$this->id = (!empty($data['id']))?$data['id']:'';
		$this->pid = (!empty($data['pid']))?$data['pid']:'';
		$this->name = (!empty($data['name']))?$data['name']:'';
		$this->module = (!empty($data['module']))?$data['module']:'';
		$this->controller = (!empty($data['controller']))?$data['controller']:'';
		$this->url = (!empty($data['url']))?$data['url']:'';
		$this->acl = (!empty($data['acl']))?$data['acl']:'';
		$this->sorting = (!empty($data['sorting']))?$data['sorting']:'';
		$this->display = (!empty($data['display']))?$data['display']:'';
	}
	
	public function getArrayCopy(){
		return get_object_vars($this);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('不使用');
	}
	
	// 获取收入类型过滤器，对指定的表单元素进行过滤
	public function getInputFilter()
	{
		if(!$this->inputFilter){
			//实例化一个InputFilter过滤器
			$inputFilter = new InputFilter();
	
			$inputFilter->add(array(
				'name'=>'id',
				'required'=>true,
				'filters'=>array(
					array('name'=>'Int'),
				)
			));
			
			$inputFilter->add(array(
				'name'=>'name',
				'required'=>true,
				'filters'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding'=>'UTF-8',
							'min'=>0,
							'max'=>255,
						)
					),
					/* array(
					 'name'	=> 'Db\NoRecordExists',
						'options' => array(
							'table' => 'lic_user',
							'field' => 'username',
							'adapter' => $this->adapter,
						),
					), */
				)
			));
	
			$inputFilter->add(array(
				'name'=>'module',
				'required'=>true,
				'filters'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
						'name'=>'StringLength',
						'options'=>array(
								'encoding'=>'UTF-8',
								'min'=>0,
								'max'=>255,
						)
					),
				)
			));
			
			$inputFilter->add(array(
				'name'=>'url',
				'required'=>true,
				'filters'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
						'name'=>'StringLength',
						'options'=>array(
								'encoding'=>'UTF-8',
								'min'=>0,
								'max'=>1024,
						)
					),
				)
			));
			
			$inputFilter->add(array(
				'name'=>'acl',
				'required'=>true,
				'filters'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
						'name'=>'StringLength',
						'options'=>array(
								'encoding'=>'UTF-8',
								'min'=>0,
								'max'=>255,
						)
					),
				)
			));
	
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}
}