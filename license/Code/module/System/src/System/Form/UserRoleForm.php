<?php
namespace System\Form;

use Zend\Form\Form;

class UserRoleForm extends Form
{
	public function __construct($name=null){
		parent::__construct('userrole');
		
		$this->add(array(
			'name'=>'submit',
			'type'=>'Submit',
			'attributes'=>array(
				'value'=>'Submit',
				'id'=>'submitbutton',
				'class'=>'btn btn-primary',	
				)	
			));
		
		$this->add(array(
			'name'=>'status',
			'type'=>'Radio',
			'options'=>array(
				'value_options'=>array('Y'=>'启用','N'=>'禁用')	
					),
			'attributes'=>array(
				'value'=>'Y',	
				)	
			));
		
		$this->add(array(
			'name'=>'acl',
			'type'=>'Textarea',
			'options'=>array(),
			'attributes'=>array(
				'class'=>'form-control',
				)	
			));
		
		$this->add(array(
			'name'=>'role_name',
			'type'=>'Text',
			'options'=>array(),
			'attributes'=>array(
				'class'=>'form-control',
				)	
			));
		
		$this->add(array(
			'name'=>'id',
			'type'=>'Hidden',	
			));
		
		$this->setAttribute('method', 'Post');
	}
}