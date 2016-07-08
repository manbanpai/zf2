<?php
namespace System\Model;

use Zend\InputFilter\InputFilter;

use Zend\InputFilter\InputFilterInterface;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

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
							'min'=>1,
							'max'=>30,
						    'messages' => array(
						        StringLength::TOO_SHORT => '字符太少，请输入1个字符。',
						        StringLength::TOO_LONG => '字符太多，请输入30个字符。'
						    )
						)
					),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
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