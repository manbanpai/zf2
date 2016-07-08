<?php
namespace Base\Model;

use Zend\Paginator\Paginator;

use Zend\Paginator\Adapter\DbSelect;

use Zend\Db\ResultSet\ResultSet;

use Zend\Db\Sql\Select;

use Zend\Db\TableGateway\TableGateway;

class AreaTable
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tg)
	{
		$this->tableGateway = $tg;
	}
	
	public function saveArea(Area $area)
	{
		$data = array(
			'title'=>$area->title,
			'pid'=>$area->pid,
			'lev'=>$area->lev,
			'sort'=>$area->sort,	
		);
	
		$id = (int)$company->id;
		if ($id == 0){
			return $this->tableGateway->insert($data);
		}else{
			if ($this->getCompany($id)){
				return $this->tableGateway->update($data, array('id'=>$id));
			}else{
				throw new \Exception("Form id does not exist");
			}
		}
	}
	
	public function getArea($id)
	{
		$id = (int)$id;
		$rowset = $this->tableGateway->select(array('id'=>$id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
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
				$select->from(array('t'=>'lic_area'));
				if($where != null)
					$select->where($where);
	
				if($order != null)
					$select->order($order);
	
				if($join != null && !empty($join))
					$select->join($join['name'], $join['on'],$join['columns'],$join['type']?:$select::JOIN_INNER);
	
				$result = new ResultSet();
				$result->setArrayObjectPrototype(new Config());
	
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