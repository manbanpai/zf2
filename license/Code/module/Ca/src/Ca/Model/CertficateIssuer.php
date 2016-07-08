<?php
namespace Ca\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;

class CertficateIssuer implements InputFilterAwareInterface
{
    public $id;
    public $issuer_country_name;
    public $issuer_state_or_province_name;
    public $issuer_locality_name;
    public $issuer_organization_name;
    public $issuer_organizational_unit_name;
    public $issuer_common_name;
    public $issuer_email_address;    
    public $issuer_surname;
    
    protected $inputFilter;
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : '';
        $this->issuer_country_name = (!empty($data['issuer_country_name'])) ? $data['issuer_country_name'] : '';
        $this->issuer_state_or_province_name = (!empty($data['issuer_state_or_province_name'])) ? $data['issuer_state_or_province_name'] : '';
        $this->issuer_locality_name = (!empty($data['issuer_locality_name'])) ? $data['issuer_locality_name'] : '';
        $this->issuer_organization_name = (!empty($data['issuer_organization_name'])) ? $data['issuer_organization_name'] : '';
        $this->issuer_organizational_unit_name = (!empty($data['issuer_organizational_unit_name'])) ? $data['issuer_organizational_unit_name'] : '';        
        $this->issuer_common_name = (!empty($data['issuer_common_name'])) ? $data['issuer_common_name'] : '';
        $this->issuer_email_address = (!empty($data['issuer_email_address'])) ? $data['issuer_email_address'] : '';        
        $this->issuer_surname = (!empty($data['issuer_surname'])) ? $data['issuer_surname'] : '';
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
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
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                )
            )));
            $inputFilter->add(array(
                'name' => 'issuer_country_name',
                'required' => true,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 2,
                        )
                    ),
                ),
                'error_message' => '请输入2个字符。'
            ));
            $inputFilter->add(array(
                'name' => 'issuer_state_or_province_name',
                'required' => true,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                ),
                'error_message' => '不能为空。',
            ));
            $inputFilter->add(array(
                'name' => 'issuer_locality_name',
                'required' => true,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                ),
                'error_message' => '不能为空。',
            ));
            $inputFilter->add(array(
                'name' => 'issuer_organization_name',
                'required' => true,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                ),
                'error_message' => '不能为空。',
            ));
            $inputFilter->add(array(
                'name' => 'issuer_organizational_unit_name',
                'required' => true,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                ),
                'error_message' => '不能为空。'
            ));
            $inputFilter->add(array(
                'name' => 'issuer_common_name',
                'required' => true,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                ),
                'error_message' => '不能为空。'
            ));
            $inputFilter->add(array(
                'name' => 'issuer_email_address',
                'required' => true,
                'filter' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                        'options' => array(
                            'messages' => array(
                                EmailAddress::INVALID => '无效的类型。',
                                EmailAddress::INVALID_FORMAT => '输入不是有效的电子邮件地址。',
                                EmailAddress::INVALID_HOSTNAME => '主机名不是一个有效的主机名的电子邮件地址',
                                //EmailAddress::INVALID_MX_RECORD => '主机名似乎没有任何有效的电子邮件地址或一个MX记录',
                                //EmailAddress::INVALID_SEGMENT => '',                                
                                //EmailAddress::DOT_ATOM => '',
                                //EmailAddress::QUOTED_STRING => '',
                                //EmailAddress::INVALID_LOCAL_PART => '',
                                EmailAddress::LENGTH_EXCEEDED => '输入超过允许长度',                                
                            )
                        )
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 0,
                            'max' => 32,
                        )
                    ),
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                NotEmpty::IS_EMPTY => '不能为空。',
                            ),
                        )
                    )
                )
            ));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}