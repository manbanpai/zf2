<?php
namespace Application\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

class User implements InputFilterAwareInterface
{
	public $id;
	public $username;
	public $password;
	public $password_rand;
	public $realname;
	public $tel;
	public $mobile;
	public $position;
	public $extension;
	public $role_id;
	public $email;
	public $qq; 
	public $last_login_ip;
	public $last_login_time;
	public $login_number;
	public $online_status;
	public $login_updatetime;
	public $password_status;
	public $update_password_time;
	public $password_reset_status;
	public $password_expire_date;
	public $createtime; 
	
	
	protected $inputFilter;
	
	//对数组数据进行转换或都说是提取数组数据
	public function exchangeArray($data){
		$this->id = isset($data['id'])?$data['id']:null;
		$this->username = isset($data['username'])?$data['username']:null;
		$this->password = isset($data['password'])?$data['password']:null;
		$this->password_rand = isset($data['password_rand'])?$data['password_rand']:null;
		$this->realname = isset($data['realname'])?$data['realname']:null;
		$this->tel = isset($data['tel'])?$data['tel']:null;
		$this->mobile = isset($data['mobile'])?$data['mobile']:null;
		$this->position = isset($data['position'])?$data['position']:null;
		$this->extension = isset($data['extension'])?$data['extension']:null;
		$this->role_id = isset($data['role_id'])?$data['role_id']:null;
		$this->email = isset($data['email'])?$data['email']:null;
		$this->qq = isset($data['qq'])?$data['qq']:null; 
		$this->last_login_ip = isset($data['last_login_ip'])?$data['last_login_ip']:null;
		$this->last_login_time = isset($data['last_login_time'])?$data['last_login_time']:null;
		$this->online_status = isset($data['online_status'])?$data['online_status']:null;
		$this->login_number = isset($data['login_number'])?$data['login_number']:null;
		$this->login_updatetime = isset($data['login_updatetime'])?$data['login_updatetime']:null;
		$this->password_status = isset($data['password_status'])?$data['password_status']:null;
		$this->update_password_time = isset($data['update_password_time'])?$data['update_password_time']:null;
		$this->password_reset_status = isset($data['password_reset_status'])?$data['password_reset_status']:null;
		$this->password_expire_date = isset($data['password_expire_date'])?$data['password_expire_date']:null;
		$this->createtime = isset($data['createtime'])?$data['createtime']:null;
		/* foreach($data as $k=>$d){
			$this->$k = $d;
		} */
	}
	
	//将类属性转化为一个关联数组，方便后续的使用
	public function getArrayCopy(){
		return get_object_vars($this);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('不使用');
	}
	
	public function getInputFilter()
	{
		if(!$this->inputFilter){
			
			$inputFilter = new InputFilter();
			
		
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}