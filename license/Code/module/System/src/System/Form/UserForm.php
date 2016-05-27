<?php
namespace System\Form;

use Zend\Form\Form;

class UserForm extends Form{
	
	public function __construct($name = null){
		parent::__construct('user');
		
		$this->add(array(
			'name'=>'submit',
			'type'=>'Submit',
			'attributes'=>array(
				'value'=>'Submit',
				'id'=>'submitbutton',
				'class'=>'btn btn-primary'
				),
			));
		
		$this->add(array(
			'name'=>'qq',
			'type'=>'Text',
			'options'=>array(
				//'label'=>'Qq',
				),
			'attributes'=>array(
				'class'=>'form-control'
				)
			));
		
		$this->add(array(
			'name'=>'email',
			'type'=>'Text',
			'options'=>array(
				//'label'=>'Email',
				),
			'attributes'=>array(
				'class'=>'form-control'
				)
			));
		
		$this->add(array(
			'name'=>'role_id',
			'type'=>'select',
			'options'=>array(
				//'label'=>'Role_id',
				),
			'attributes'=>array(
				'required' => 'required',
				'class'=>'form-control',
				)
			));
		
		$this->add(array(
				'name'=>'extension',
				'type'=>'Text',
				'options'=>array(
				//'label'=>'Position',
				),
				'attributes'=>array(
						'class'=>'form-control'
				)
		));
		
		$this->add(array(
			'name'=>'position',
			'type'=>'Text',
			'options'=>array(
				//'label'=>'Position',
				),
			'attributes'=>array(
				'class'=>'form-control'
				)
			));
		
		$this->add(array(
			'name'=>'mobile',
			'type'=>'Text',
			'options'=>array(
				//'label'=>'Mobile',
				),
			'attributes'=>array(
				'class'=>'form-control'
				)
			));
		
		$this->add(array(
			'name'=>'tel',
			'type'=>'Text',
			'options'=>array(
				//'label'=>'Tel',
				),
			'attributes'=>array(
				'class'=>'form-control'
				)
			));
		
		$this->add(array(
			'name'=>'realname',
			'type'=>'Text',
			'options'=>array(
				//'label'=>'Realname',
				),
			'attributes'=>array(
				'class'=>'form-control'
				)
			));
		
		$this->add(array(
			'name'=>'password',
			'type'=>'Text',
			'options'=>array(
				//'label'=>'Password',
				),
			'attributes'=>array(
				'class'=>'form-control',
				'value'=>"",
				)
			));
		
		$this->add(array(
			'name'=>'username',
			'type'=>'Text',
			'options'=>array(
				//'label'=>'Username',
				),
			'attributes'=>array(
				'required' => 'required',
				'class'=>'form-control'	
				)
			));
		
		$this->add(array(
				'name'=>'id',
				'type'=>'Hidden',
			));
		
		$this->setAttribute('method', 'post');
	}
}