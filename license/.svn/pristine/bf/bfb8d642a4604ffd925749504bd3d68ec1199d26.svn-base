<?php
namespace System\Model;

use Zend\Paginator\Paginator;

use Zend\Paginator\Adapter\DbSelect;

use Zend\Db\Adapter\Adapter;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\sql\Select;

class UserRoleTable{
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tg)
	{
		$this->tableGateway = $tg;	
	}
	
	public function deleteUserRole($id)
	{
		$this->tableGateway->delete(array('id'=>(int)$id));
	}
	
	public function saveUserRole(UserRole $userRole)
	{
		$data = array(
			'id'=>$userRole->id,
			'role_name'=>$userRole->role_name,
			'acl'=>$userRole->acl,
			'status'=>$userRole->status,
			'createtime'=>$userRole->createtime,		
		);
		
		$id = (int) $userRole->id;
		
		if($id == 0){
			$this->tableGateway->insert($data);
		}else{
			if($this->getUserRole($id)){
				$this->tableGateway->update($data,array('id'=>$id));
			}else{
				throw new \Exception("User表中没有ID为$id的记录");
			}
		}
	}
	
	public function getUserRole($id)
	{
		$id = (int) $id;
		$rowset = $this->tableGateway->select(array('id'=>$id));
		$row = $rowset->current();
		if(!$row){
			throw new \Exception("没有找到ID为$id的数据");
		}
		return $row;
	}
	
	public function fetchAll(array $params = null)
	{
		if(!empty($params)){
			$paginated = isset($params['paginated'])?$params['paginated']:null;
			$where = isset($params['where'])?$params['where']:null;
			$order = isset($params['order'])?$params['order']:null;
			$join = isset($params['join'])?$params['join']:null;
			
			if($paginated){
				$select = new Select();
				$select->from(array('t'=>'lic_user_role'));
				if($where != null)
					$select->where($where);
				
				if($order != null)
					$select->order($order);
				
				if($join != null && !empty($join))
					$select->join($join['name'], $join['on'],$join['columns'],$join['type']?:$select::JOIN_INNER);	
				
				$result = new ResultSet();
				$result->setArrayObjectPrototype(new UserRole());
				
				$paginatorAdapter = new DbSelect(
						$select, 
						$this->tableGateway->getAdapter(),
						$result
						);
				
				$paginator = new Paginator($paginatorAdapter);
				return $paginator;
			}
			
			$resultSet = $this->tableGateway->select(function(Select $select) use($where,$order,$join){
				if($where !=null){
					$select->where($where);
				}
				if($order != null){
					$select->order($order);
				}
				if($join != null){
					$select->join($join['name'], $join['on'],$join['columns'],$join['type']?:$select::JOIN_INNER);	
				}
			});
			return $resultSet;
		}else{
			return $this->tableGateway->select();
		}
	}
}