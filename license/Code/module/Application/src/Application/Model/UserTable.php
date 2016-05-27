<?php
namespace Application\Model;

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
			'id'=>isset($user->id)?$user->id:0,
			'username'=>isset($user->username)?$user->username:'',
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
			'login_number'=>$user->login_number,
			'last_login_time'=>$user->last_login_time,
			'last_login_ip'=>$user->last_login_ip,
			'online_status'=>$user->online_status,	
		);
		$id = (int) $user->id;
		if($id == 0){
			$this->tableGateway->insert($data);
		}else{
			if($this->getUser($id)){
				$this->tableGateway->update($data,array('id'=>$id));
			}else{
				throw new \Exception("User表中没有ID为$id的记录");
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
	
	public function getUserByArray(array $arr)
	{
		if(!empty($arr)){
			$rowset = $this->tableGateway->select($arr);
			$row = $rowset->current();
			if(!$row){
				return false;
			}
			return $row;
		}
	}
	
	//查询全部数据
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
}