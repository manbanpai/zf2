<?php
namespace Log\Model;

class Log
{
	public $id;
	public $user_id;
	public $cate_name;
	public $url;
	public $intro;
	public $ip;
	public $display;
	public $create_time;
	public $username;
	public $c;
	
	public function exchangeArray($data)
	{
		$this->id = (!empty($data['id']))?$data['id']:'';
		$this->user_id = (!empty($data['user_id']))?$data['user_id']:'';
		$this->cate_name = (!empty($data['cate_name']))?$data['cate_name']:'';
		$this->url = (!empty($data['url']))?$data['url']:'';
		$this->intro = (!empty($data['intro']))?$data['intro']:'';
		$this->ip = (!empty($data['ip']))?$data['ip']:'';
		$this->display = (!empty($data['display']))?$data['display']:'';
		$this->create_time = (!empty($data['create_time']))?$data['create_time']:'';
		$this->username = (!empty($data['username']))?$data['username']:'';
		$this->c = (!empty($data['c']))?$data['c']:'';
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}