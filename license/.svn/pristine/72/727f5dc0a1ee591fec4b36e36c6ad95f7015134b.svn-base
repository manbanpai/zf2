<?php
namespace Base\Form;

use Zend\Form\Form;

class ConfigForm extends Form
{
	public function __construct($name=null)
	{
		parent::__construct('config');
		
		$this->setAttribute('method', 'POST');
		
		$this->add(array(
			'name'=>'scope',
			'type'=>'Select',
			'options'=>array(
				'value_options'=>array(
					'base'=>'base','upload'=>'upload','others'=>'others'	
					)	
				),
			'attributes'=>array(
				'class'=>'form-control',	
				)	
			));
		
		$this->add(array(
			'name'=>'variable',
			'type'=>'Text',
			'options'=>array(),
			'attributes'=>array(
				'class'=>'form-control',	
				)	
			));
		
		$this->add(array(
			'name'=>'value',
			'type'=>'Text',
			'options'=>array(),
			'attributes'=>array(
				'class'=>'form-control',
			)
		));
		
		$this->add(array(
			'name'=>'description',
			'type'=>'Textarea',
			'options'=>array(),
			'attributes'=>array(
					'class'=>'form-control',
			)
		));
		
		$this->add(array(
				'name'=>'submit',
				'type'=>'Submit',
				'options'=>array(),
				'attributes'=>array(
						'class'=>'btn btn-primary',
						'value'=>'提交'
				)
		));
	}
}