<?php
namespace Ca\Form;

use Zend\Form\Form;

class CertficateForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('certficate');
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
            'name' => 'issuer_id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'user_country_name',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'required' => 'required',
                'readonly' => 'true',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'user_state_or_province_name',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'required' => 'required',
                'readonly' => 'true',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'user_locality_name',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'required' => 'required',
                'readonly' => 'true',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'user_organization_name',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'required' => 'required',
                'readonly' => 'true',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'user_organizational_unit_name',
            'type' => 'Text',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'required' => 'required',
                'readonly' => 'true',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'user_common_name',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'required' => 'required',
                'readonly' => 'true',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'user_email_address',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'required' => 'required',
                'readonly' => 'true',
                'class' => 'form-control',
            )
        ));        
        $this->add(array(
            'name' => 'user_surname',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'valid_days',
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
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => '生成',
                'id' => 'submitbutton',
                'class' => 'btn btn-info',
            )
        ));
    }
}