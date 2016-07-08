<?php
namespace Member\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Form\Fieldset;
class SendMailForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('sendmail');
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
            'name' => 'send',
            'type' => 'Hidden',
        ));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'options' => array(
                'label' => ''
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
                'value' => '发送',
                'class' => 'btn btn-info'
            )
        ));
    }
}