<?php
namespace System\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class MenuPermiTable
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tg)
	{
		$this->tableGateway = $tg;
	}
	
	public function deleteMenuPermi($id)
	{
		$id = (int) $id;
		if($id){
			$this->tableGateway->delete(array('id'=>$id));
		}
	}
	
	public function insertMenuPermi(array $data)
	{
		if(!empty($data)){
			$this->tableGateway->insert($data);
		}
	}
	
	public function fetchAll($where=null)
	{
		$resultSet = $this->tableGateway->select($where);
		return $resultSet;
	}
}