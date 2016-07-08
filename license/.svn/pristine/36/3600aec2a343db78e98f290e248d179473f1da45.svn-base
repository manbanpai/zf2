<?php
namespace Member\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class CertficateTable extends AbstractTableGateway
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    /**
     * 获取所有表数据
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    /**
     * 返回选择框格式的数据
     * @param array $arr
     * @return multitype:string NULL
     */
    public function getSelect($arr)
    {
        $data = array(''=>'请选择');
        foreach ($arr as $row){
            $data[$row->id] = $row->serial;
        }
        return $data;
    }
    
    /**
     * 获取证书id
     * @param string $serial
     * @return $arr
     */
    public function getCertId($serial)
    {
        $resultSet = $this->tableGateway->select("serial='".$serial."'");
        return $resultSet->current();
    }
    
    /**
     * 获取数量
     * @param string $serial
     * @return number
     */
    public function getCount($serial)
    {
        $resultSet = $this->tableGateway->select("serial='".$serial."'");
        return $resultSet->count();
    }
}
