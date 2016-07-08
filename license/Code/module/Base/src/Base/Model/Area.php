<?php
namespace Base\Model;

class Area
{
	public $area_id;
	public $title;
	public $pid;
	public $sort;
	public $lev;
	
	public function exchangeArray($data)
	{
		$this->area_id = (!empty($data['area_id']))?$data['area_id']:'';
		$this->title = (!empty($data['title']))?$data['title']:'';
		$this->pid = (!empty($data['pid']))?$data['pid']:'';
		$this->sort = (!empty($data['sort']))?$data['sort']:'';
		$this->lev = (!empty($data['lev']))?$data['lev']:'';
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}