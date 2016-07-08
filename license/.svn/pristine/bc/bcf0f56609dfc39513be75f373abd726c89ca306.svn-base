<?php
namespace Member\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Area implements InputFilterAwareInterface
{
    public $area_id;
    public $title;
    public $pid;
    public $sort;
    protected $inputFilter;
    
    public function exchangeArray($data)
    {
        $this->area_id = (!empty($data['area_id'])) ? $data['area_id'] : '';
        $this->title = (!empty($data['title'])) ? $data['title'] : '';
        $this->pid = (!empty($data['pid'])) ? $data['pid'] : '';
        $this->sort = (!empty($data['sort'])) ? $data['sort'] : '';        
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
                'name'      => 'area_id',
                'required'  => true,
                'filters'   => array(
                    array('name'=>'Int'),
                )
            )));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}