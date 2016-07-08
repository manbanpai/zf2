<?php
namespace Application\Form;

use Zend\Form\Form;

class UserForm extends Form{
	
	public function __construct($name = null){
		parent::__construct('user');
		
		$this->add(array(
			'name'=>'submit',
			'type'=>'Submit',
			'attributes'=>array(
				'value'=>'登录',
				'id'=>'submitbutton',
				'class'=>'btn btn-lg btn-primary btn-block',
				),
			));
		
		$this->add(array(
			'name'=>'password',
			'type'=>'Password',
			'options'=>array(
				//'label'=>'Password',
				),
			'attributes'=>array(
				'class'=>'form-control',
				'value'=>"",
				'placeholder'=>"密码",
				'required' => 'required',
				)
			));
		
		$this->add(array(
			'name'=>'username',
			'type'=>'Text',
			'options'=>array(
				//'label'=>'Username',
				),
			'attributes'=>array(
				'class'=>'form-control',
				'placeholder'=>"用户名", 
				'required' => 'required', 
				'autofocus'
				)
			));
		
		$this->add(array(
				'name'=>'id',
				'type'=>'Hidden',
			));
		
		$this->setAttribute('method', 'post');
		$this->setAttribute('class','form-signin');
	}
}