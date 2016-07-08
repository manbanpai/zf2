<?php
namespace Ca\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;
use Zend\Form\Element;

class CompanyForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('company');
        $this->addElement();
    }
    
    public function addElement()
    {
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'company_name',
            'type' => 'Text', 
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(                
                'required' => 'required',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'tel',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'fax',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'contacts',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'vocation',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'mobile',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'place',
            'type' => 'Hidden',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'place',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'address',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'url',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'introduce',
            'type' => 'textarea',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'cols' => 55,
                'rows' => 10,
                'class' => 'form-control',
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'logo', 
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => '添加',
                'id' => 'submitbutton',
                'class' => 'btn btn-info'
            )
        ));
    }
    
    public function elementProvince($arr=array(), $val=0)
    {
        $province = new Select('province');
        $province->setAttribute('id', 'province');
        $province->setAttribute('onchange', 'getCity()');
        $province->setAttribute('class', 'form-control');
        $province->setDisableInArrayValidator(true);
        $province->setValue($val);
        $province->setValueOptions($arr);
        $this->add($province);
    }
    
    public function elementCity($arr=array(), $val=0)
    {
        $city = new Select('city');
        $city->setAttribute('id', 'city');
        $city->setAttribute('onchange', 'getArea()');
        $city->setAttribute('class', 'form-control');
        $city->setDisableInArrayValidator(true);
        $city->setValue($val);
        $city->setValueOptions($arr);
        $this->add($city);
    }
    
    public function elementArea($arr=array(), $val=0)
    {
        $area = new Select('area');
        $area->setAttribute('id', 'area');
        $area->setAttribute('class', 'form-control');
        $area->setDisableInArrayValidator(true);
        $area->setValue($val);
        $area->setValueOptions($arr);
        $this->add($area);
    }
}