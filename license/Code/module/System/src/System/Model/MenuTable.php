<?php
namespace System\Model;

use Zend\Paginator\Paginator;

use Zend\Paginator\Adapter\DbSelect;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class MenuTable
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tg)
	{
		$this->tableGateway = $tg;
	}
	
	public function deleteMenu($id){
		$this->tableGateway->delete(array('id'=>(int) $id));
	}
	
	public function saveMenu(Menu $menu)
	{
		$data = array(
			'pid'=>$menu->pid,
			'name'=>$menu->name,
			'module'=>$menu->module,
			'controller'=>$menu->controller,
			'url'=>$menu->url,
			'acl'=>$menu->acl,
			'display'=>$menu->display,	
			);
		
		$id = (int) $menu->id;
		
		if($id == 0){
			$this->tableGateway->insert($data);
		}else{
			if($this->getMenu($id)){
				$this->tableGateway->update($data,array('id'=>$id));
			}else{
				return false;
			}
		}
	}
	
	public function getMenu($id)
	{
		$id = (int)$id;
		if($id){
			$rowset = $this->tableGateway->select(array('id'=>$id));
			$row = $rowset->current();
			if(!$row){
				return false;
			}
			return $row;
		}
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
				$select->from(array('t'=>'lic_user_menu'));
				if($where != null)
					$select->where($where);
				
				if($order != null)
					$select->order($order);
				
				if($join != null && !empty($join))
					$select->join($join['name'], $join['on'],$join['columns'],$join['type']?:$select::JOIN_INNER);	
				
				$result = new ResultSet();
				$result->setArrayObjectPrototype(new Menu());
				
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