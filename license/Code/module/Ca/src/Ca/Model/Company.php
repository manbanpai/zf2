<?php
namespace Ca\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Company implements InputFilterAwareInterface
{
    public $id;
    public $company_name;
    public $tel;
    public $fax;
    public $contacts;
    public $vocation;
    public $mobile;
    public $email;
    public $province;
    public $city;
    public $area;
    public $address;
    public $url;
    public $introduce;
    public $logo;
    
    protected $inputFilter;    
    
    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : '';
        $this->company_name = (!empty($data['company_name'])) ? $data['company_name'] : '';
        $this->tel = (!empty($data['tel'])) ? $data['tel'] : '';
        $this->fax = (!empty($data['fax'])) ? $data['fax'] : '';
        $this->contacts = (!empty($data['contacts'])) ? $data['contacts'] : '';
        $this->vocation = (!empty($data['vocation'])) ? $data['vocation'] : '';
        $this->mobile = (!empty($data['mobile'])) ? $data['mobile'] : '';
        $this->email = (!empty($data['email'])) ? $data['email'] : '';
        $this->province = (!empty($data['province'])) ? $data['province'] : '0';
        $this->city = (!empty($data['city'])) ? $data['city'] : '0';
        $this->area = (!empty($data['area'])) ? $data['area'] : '0';
        $this->address = (!empty($data['address'])) ? $data['address'] : '';
        $this->url = (!empty($data['url'])) ? $data['url'] : '';
        $this->introduce = (!empty($data['introduce'])) ? $data['introduce'] : '';
        $this->logo = (!empty($data['logo'])) ? $data['logo'] : '';
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
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name'      => 'id',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'Int'),
                )
            )));
            $this->inputFilter = $inputFilter;
        }        
        return $this->inputFilter;
    }
}