<?php
namespace System\Model;

class MenuPermi
{
	public $id;
	public $menu_id;
	public $name;
	public $operation;
	public $sort;
	
	public function exchangeArray($data)
	{
		$this->id = isset($data['id'])?$data['id']:null;
		$this->menu_id = isset($data['menu_id'])?$data['menu_id']:null;
		$this->name = isset($data['name'])?$data['name']:null;
		$this->operation = isset($data['operation'])?$data['operation']:null;
		$this->sort = isset($data['sort'])?$data['sort']:null;
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	
}