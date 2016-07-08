<?php
namespace Member\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;

class AreaTable extends AbstractTableGateway
{
    protected $tableGateway;
        
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    /**
     * 获取地区
     * @param number $pid
     */
    public function getArea($pid=0)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->where("pid=$pid");
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }
    
    /**
     * 返回下拉框
     * @param number $pid
     * @return multitype:string NULL
     */
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