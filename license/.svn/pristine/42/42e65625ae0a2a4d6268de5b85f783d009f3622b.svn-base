<?php
namespace System\Form;

use Zend\Form\Form;

class MenuForm extends Form
{
	public function __construct($name=null)
	{
		parent::__construct('menu');
		
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
			'name'=>'display',
			'type'=>'Radio',
			'options'=>array(
			//'label'=>'Username',
				'value_options'=>array('Y'=>'可见','N'=>'不可见')
			),
			'attributes'=>array(
				'value'=>'Y',
			)
		));
		
		$this->add(array(
			'name'=>'acl',
			'type'=>'Text',
			'options'=>array(
			//'label'=>'Username',
			),
			'attributes'=>array(
					'class'=>'form-control'
			)
		));
		
		$this->add(array(
			'name'=>'url',
			'type'=>'Text',
			'options'=>array(
			//'label'=>'Username',
			),
			'attributes'=>array(
					'class'=>'form-control'
			)
		));
		
		$this->add(array(
			'name'=>'url',
			'type'=>'Text',
			'options'=>array(
			//'label'=>'Username',
			),
			'attributes'=>array(
					'class'=>'form-control'
			)
		));
		
		$this->add(array(
			'name'=>'module',
			'type'=>'Text',
			'options'=>array(
			//'label'=>'Username',
			),
			'attributes'=>array(
					'class'=>'form-control'
			)
		));
		
		$this->add(array(
			'name'=>'pid',
			'type'=>'Select',
			'options'=>array(
			//'label'=>'Username',
			),
			'attributes'=>array(
					'class'=>'form-control'
			)
		));
		
		$this->add(array(
			'name'=>'name',
			'type'=>'Text',
			'options'=>array(
			//'label'=>'Username',
			),
			'attributes'=>array(
					'class'=>'form-control'
			)
		));
		
		$this->add(array(
				'name'=>'id',
				'type'=>'Hidden',
				'options'=>array(
				//'label'=>'Username',
				),
				'attributes'=>array(
						'class'=>'form-control'
				)
		));
		
		$this->setAttribute('method', 'post');
	}
}