<?php
namespace Ca\Form;

use Zend\Form\Form;

class CertficateIssuerForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('certficate_issuer');
        $this->addElement();
    }
    
    public function addElement()
    {
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        //C
        $this->add(array(
            'name' => 'issuer_country_name',
            'type' => 'Text',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'required' => 'required',
                'maxlength' => '2',
                'class' => 'form-control',
            )
        ));
        //ST
        $this->add(array(
            'name' => 'issuer_state_or_province_name',
            'type' => 'Text',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'required' => 'required',
                'maxlength' => '64',
                'class' => 'form-control',
            )
        ));
        //L
        $this->add(array(
            'name' => 'issuer_locality_name',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'required' => 'required',
                'maxlength' => '64',
                'class' => 'form-control',
            )
        ));
        //O
        $this->add(array(
            'name' => 'issuer_organization_name',
            'type' => 'Text',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'required' => 'required',
                'maxlength' => '64',
                'class' => 'form-control',
            )
        ));
        //OU
        $this->add(array(
            'name' => 'issuer_organizational_unit_name',
            'type' => 'Text',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'required' => 'required',
                'maxlength' => '64',
                'class' => 'form-control',
            )
        ));
        //CN
        $this->add(array(
            'name' => 'issuer_common_name',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'required' => 'required',
                'maxlength' => '64',
                'class' => 'form-control',
            )
        ));
        //E
        $this->add(array(
            'name' => 'issuer_email_address',
            'type' => 'Text',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'required' => 'required',
                'maxlength' => '32',
                'class' => 'form-control',
            )
        ));
        //SN
        $this->add(array(
            'name' => 'issuer_surname',
            'type' => 'Text',
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
                'class' => 'btn btn-info',
            )
        ));
    }
}