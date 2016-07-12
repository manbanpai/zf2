<?php
namespace Member\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class License implements InputFilterAwareInterface
{
    public $id;
    public $max_client_number;
    public $soft_valid_days;
    public $app_number;
    public $client_info;
    public $server_domain;
    public $server_cpu_id;
    public $server_ip;
    public $server_mac;
    public $license_savepath;
    public $sha1file;
    public $status;
    public $create_time;
    public $serialnumber;
    public $certficate_id;
    public $membercompany_id;
    public $expire_time;
    public $audit;
    
    public $serial;
    
    public $company_name;
    public $tel;
    public $fax;
    public $contact;
    public $profession;
    public $mobile;
    public $email;
    public $other;   
    
    protected $inputFilter;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : '';
        $this->max_client_number = (!empty($data['max_client_number'])) ? $data['max_client_number'] : '';
        $this->soft_valid_days = (!empty($data['soft_valid_days'])) ? $data['soft_valid_days'] : '';
        $this->app_number = (!empty($data['app_number'])) ? $data['app_number'] : '';
        $this->client_info  = (!empty($data['client_info'])) ? $data['client_info'] : '';
        $this->server_domain = (!empty($data['server_domain'])) ? $data['server_domain'] : '';
        $this->server_ip = isset($data['server_ip']) ? $data['server_ip'] : '';
        $this->server_cpu_id = isset($data['server_cpu_id']) ? $data['server_cpu_id'] : '';
        $this->server_mac = isset($data['server_mac']) ? $data['server_mac'] : '';
        $this->license_savepath = (!empty($data['license_savepath'])) ? $data['license_savepath'] : '';
        $this->sha1file = (!empty($data['sha1file'])) ? $data['sha1file'] : '';
        $this->status = (!empty($data['status'])) ? $data['status'] : '';
        $this->create_time = (!empty($data['create_time'])) ? $data['create_time'] : 0;
        $this->serialnumber = (!empty($data['serialnumber'])) ? $data['serialnumber'] : '';
        $this->certficate_id = (!empty($data['certficate_id'])) ? $data['certficate_id'] : 0;
        $this->membercompany_id = (!empty($data['membercompany_id'])) ? $data['membercompany_id'] : 0;
        $this->serial = (!empty($data['serial'])) ? $data['serial'] : '';
        $this->expire_time = (!empty($data['expire_time'])) ? $data['expire_time'] : 0;
        $this->company_name = (!empty($data['company_name'])) ? $data['company_name'] :'';
        $this->tel = (!empty($data['tel'])) ? $data['tel'] : '';
        $this->fax = (!empty($data['fax'])) ? $data['fax'] : '';
        $this->contact = (!empty($data['contact'])) ? $data['contact'] : '';
        $this->profession = (!empty($data['profession'])) ? $data['profession'] : '';
        $this->mobile = (!empty($data['mobile'])) ? $data['mobile'] : '';
        $this->email = (!empty($data['email'])) ? $data['email'] : '';
        $this->other = (!empty($data['other'])) ? $data['other'] : '';
        $this->audit = (!empty($data['audit'])) ? $data['audit'] : '0';
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
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
                'name'      => 'id',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'Int'),
                )
            )));
            $inputFilter->add($factory->createInput(array(
                'name'      => 'max_client_number',
                'required'  => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags',
                        'name' => 'StringTrim',                        
                        'name' => 'Digits',
                    )
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'Digits'),
                    array('name' => 'Between', 
                        'options' => array(
                            'min' => 1,
                            'max' => 2000,
                        ),                        
                    ),
                ),
                'error_message' => '必须为数字，不能为空，范围在1至2000个。'
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'app_number',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags',
                        'name' => 'StringTrim',
                        'name' => 'Digits',
                    )
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'Digits'),
                    array('name' => 'Between',
                        'options' => array(
                            'min' => 1,
                            'max' => 2000,
                        ),
                    ),
                ),
                'error_message' => '必须为数字，不能为空，范围在1至2000个。'
            )));
            $inputFilter->add($factory->createInput(array(
                'name'      => 'soft_valid_days',
                'required'  => true,
                'filters'   => array(
                    array(
                        'name' => 'StripTags',
                        'name' => 'StringTrim',
                        'name' => 'Digits',
                    )
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'Digits'),
                    array('name' => 'Between',
                        'options' => array(
                            'min' => 7,
                            'max' => 1095,
                        ),
                    ),
                ),
                'error_message' => '必须为数字，不能为空，范围在7天至1095天。',
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