<?php
namespace License\Form;

use Zend\Form\Form;
use Zend\Form\Element\Button;
use Zend\Form\Element;
class LicForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('lic');
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
            'name' => 'cert',
            'type' => 'File',
            'attributes' => array(
                'id' => 'cert',
                'required' => true,
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'max_client_number',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'max_client_number',
                'required' => 'required',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'soft_valid_days',
            'type' => 'Text',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'id' => 'soft_valid_days',
                'required' => 'required',
                'class' => 'form-control',
            )
        ));
        //详细信息拆分
        $this->add(array(
            'name' => 'client_info',
            'type' => 'Hidden',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'id' => 'client_info',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'company_name',
            'type' => 'Text',
            'options' => array(
                'label' => ''
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'tel',
            'type' => 'Text',
            'options' => array(
                'label' => ''
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
            'name' => 'contact',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'profession',
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
            'name' => 'other',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'server_domain',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'server_domain',
                'required' => 'required',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'server_cpu_id',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'server_cpu_id',
                'readonly' => true,
                'required' => 'required',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'server_ip',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'server_ip',
                'readonly' => true,
                'required' => 'required',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'server_mac',
            'type' => 'Text',
            'options' => array(
                'label' => '',
            ),
            'attributes' => array(
                'id' => 'server_mac',
                'readonly' => true,
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
    
    /**
     * license文件下载
     */
    public function elementDownLic()
    {
        $button = new Button('button1');
        $button->setAttribute('id', 'btn1');
        $button->setAttribute('class', 'btn btn-info');
        $button->setLabel('license文件下载');
        $this->add($button);
    }
    
    /**
     * 证书下载
     */
    public function elementDownCert()
    {
        $button = new Button('button2');
        $button->setAttribute('id', 'btn2');
        $button->setAttribute('class', 'btn btn-info');
        $button->setLabel('加密证书下载');
        $this->add($button);
    }
}