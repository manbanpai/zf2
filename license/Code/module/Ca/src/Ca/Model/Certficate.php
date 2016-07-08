<?php
namespace Ca\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\Digits;

class Certficate implements InputFilterAwareInterface
{
    public $id;
    public $issuer_id;
    public $user_country_name;
    public $user_state_or_province_name; 
    public $user_locality_name;
    public $user_organization_name;
    public $user_organizational_unit_name;
    public $user_common_name;
    public $user_email_address;    
    public $user_surname;
    public $serial;
    public $valid_days;
    public $ctype;
    public $begin_time;
    public $end_time;
    public $is_revoked;
    public $cert_savepath;
    public $sha1file;
    public $createtime;
    
    protected $inputFilter;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : '';
        $this->issuer_id = (!empty($data['issuer_id'])) ? $data['issuer_id'] : '';
        $this->user_country_name = (!empty($data['user_country_name'])) ? $data['user_country_name'] : '';
        $this->user_state_or_province_name = (!empty($data['user_state_or_province_name'])) ? $data['user_state_or_province_name'] : '';
        $this->user_organization_name = (!empty($data['user_organization_name'])) ? $data['user_organization_name'] : '';
        $this->user_organizational_unit_name = (!empty($data['user_organizational_unit_name'])) ? $data['user_organizational_unit_name'] : '';
        $this->user_common_name = (!empty($data['user_common_name'])) ? $data['user_common_name'] : '';
        $this->user_email_address = (!empty($data['user_email_address'])) ? $data['user_email_address'] : '';
        $this->user_locality_name = (!empty($data['user_locality_name'])) ? $data['user_locality_name'] : '';
        $this->user_surname = (!empty($data['user_surname'])) ? $data['user_surname'] : '';
        $this->serial = (!empty($data['serial'])) ? $data['serial'] : '';
        $this->valid_days = (!empty($data['valid_days'])) ? $data['valid_days'] : '';
        $this->ctype = (!empty($data['ctype'])) ? $data['ctype'] : '';
        $this->begin_time = (!empty($data['begin_time'])) ? $data['begin_time'] : '';
        $this->end_time = (!empty($data['end_time'])) ? $data['end_time'] : '';
        $this->is_revoked = (!empty($data['is_revoked'])) ? $data['is_revoked'] : '';
        $this->cert_savepath = (!empty($data['cert_savepath'])) ? $data['cert_savepath'] : '';
        $this->sha1file = (!empty($data['sha1file'])) ? $data['sha1file'] : '';
        $this->createtime = (!empty($data['createtime'])) ? $data['createtime'] : '';
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('Not used');
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter){
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name'      => 'id',
                'required'  => true,
                'filters'   => array(
                    array('name'=>'Int'),
                )
            )));
            $inputFilter->add($factory->createInput(array(
                'name'      => 'valid_days',
                'required'  => true,
                'filters'   => array(
                    array('name'=>'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array('name' => 'Digits'),
                ),
                'error_message' => '必须为数字，不能为空。'
            )));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}