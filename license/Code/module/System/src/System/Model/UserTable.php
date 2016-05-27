<?php
namespace System\Model;

use Zend\Paginator\Paginator;

use Zend\Paginator\Adapter\DbSelect;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class UserTable{
	protected $tableGateway;
	
	public function __construct(TableGateway $tg)
	{
		$this->tableGateway = $tg;		
	}
	
	public function deleteUser($id){
		$this->tableGateway->delete(array('id'=>(int) $id));
	}
	
	//保存记录 如果ID存在修改，如果ID不存在添加
	public function saveUser(User $user)
	{
		$data = array(
			'username'=>$user->username,
			'password'=>$user->password,
			'password_rand'=>$user->password_rand,
			'realname'=>$user->realname,
			'tel'=>$user->tel,
			'mobile'=>$user->mobile,
			'position'=>$user->position,
			'extension'=>$user->extension,
			'role_id'=>$user->role_id,
			'email'=>$user->email,
			'qq'=>$user->qq,
				/*
			'password_rand'=>$user->password_rand,
			'last_login_ip'=>$user->last_login_ip,
			'last_login_time'=>$user->last_login_time,
			'login_number'=>$user->login_number,
			'online_status'=>$user->online_status,
			'login_updatetime'=>$user->login_updatetime,
			'password_status'=>$user->password_status,
			'update_password_time'=>$user->update_password_time,
			'password_reset_status'=>$user->password_reset_status,
			'password_expire_date'=>$user->password_expire_date, */
			'createtime'=>$user->createtime,
		);
		$id = (int) $user->id;
		
		if($id == 0){
			$this->tableGateway->insert($data);
		}else{
			if($this->getUser($id)){
				$this->tableGateway->update($data,array('id'=>$id));
			}else{
				return false;
			}
		}
	}
	
	//查询单挑数据
	public function getUser($id)
	{
		$id = (int) $id;
		$rowset = $this->tableGateway->select(array('id'=>$id));
		$row = $rowset->current();
		if(!$row){
			return false;
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
				$select->from(array('t'=>'lic_user'));
				if($where != null)
					$select->where($where);
				
				if($order != null)
					$select->order($order);
				
				if($join != null && !empty($join))
					$select->join($join['name'], $join['on'],$join['columns'],$join['type']?:$select::JOIN_INNER);	
				
				$result = new ResultSet();
				$result->setArrayObjectPrototype(new User());
				
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