<?php
namespace License\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Lic implements InputFilterAwareInterface
{

    public $max_client_number;
    public $soft_valid_days;
    
    public $client_info;
    //详细信息拆分内容
    public $company_name;
    public $tel;
    public $fax;
    public $contact;
    public $profession;
    public $mobile;
    public $email;
    public $other;
    
    public $server_domain;
    public $server_cpu_id;
    public $server_ip;
    public $server_mac;
    
    public $inputFilter;
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function exchangeArray($data)
    {
        $this->max_client_number = (!empty($data['max_client_number'])) ? $data['max_client_number'] : '';
        $this->soft_valid_days = (!empty($data['soft_valid_days'])) ? $data['soft_valid_days'] : '';
        $this->client_info  = (!empty($data['client_info'])) ? $data['client_info'] : '';
        $this->server_domain = (!empty($data['server_domain'])) ? $data['server_domain'] : '';
        $this->server_cpu_id = (!empty($data['server_cpu_id'])) ? $data['server_cpu_id'] : '';
        $this->server_mac = (!empty($data['server_mac'])) ? $data['server_mac'] : '';
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter){
            $inputFilter    = new InputFilter();
            $factory        = new InputFactory();
    
            $inputFilter->add($factory->createInput(array(
                'name'      => 'max_client_number',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'Digits'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty')
                ),
                'error_message' => '必须为数字，不能为空。',
            )));
            $inputFilter->add($factory->createInput(array(
                'name'      => 'soft_valid_days',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'Digits'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty')
                ),
                'error_message' => '必须为数字，不能为空。',
            )));            
            $inputFilter->add($factory->createInput(array(
                'name'      => 'server_domain',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array(
                    array('name' => 'NotEmpty')
                ),
                'error_message' => '不能为空。',
            )));
            $inputFilter->add($factory->createInput(array(
                'name'      => 'server_cpu_id',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array(
                    array('name' => 'NotEmpty')
                ),
                'error_message' => '不能为空。',
            )));
            $inputFilter->add($factory->createInput(array(
                'name'      => 'server_ip',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array(
                    array('name' => 'NotEmpty')
                ),
                'error_message' => '不能为空。',
            )));
            $inputFilter->add($factory->createInput(array(
                'name'      => 'server_mac',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim')
                ),
                'validators' => array(
                    array('name' => 'NotEmpty')
                ),
                'error_message' => '不能为空。',
            )));
    
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}