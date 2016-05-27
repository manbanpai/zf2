<?php
namespace Ca\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;

class AreaTable extends AbstractTableGateway
{
    protected $tableGateway;
        
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getArea($pid=0)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where("pid=$pid");
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }
    
    public function getAreaToSelect($pid=0)
    {
        $country = $this->getArea($pid);
        $arr = array('请选择');
        foreach ($country as $row){
            $arr[$row->area_id] = $row->title;
        }
        return $arr;
    }
    
}