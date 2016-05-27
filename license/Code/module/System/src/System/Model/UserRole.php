<?php
namespace System\Model;

use Zend\InputFilter\InputFilter;

use Zend\InputFilter\InputFilterInterface;

use Zend\InputFilter\InputFilterAwareInterface;

class UserRole implements InputFilterAwareInterface
{
	public $id;
	public $role_name;
	public $acl;
	public $status;
	public $createtime;
	
	protected $inputFilter;
	
	public function exchangeArray($data)
	{
		$this->id = (!empty($data['id']))?$data['id']:'';
		$this->role_name = (!empty($data['role_name']))?$data['role_name']:'';
		$this->acl = (!empty($data['acl']))?$data['acl']:'';
		$this->status = (!empty($data['status']))?$data['status']:'';
		$this->createtime = (!empty($data['createtime']))?$data['createtime']:'';
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('不使用');
	}
	
	public function getInputFilter()
	{
		if(!$this->inputFilter){
			
			$inputFilter = new InputFilter();
			
			$inputFilter->add(array(
				'name'=>'role_name',	
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
								'max'=>128,
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
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}