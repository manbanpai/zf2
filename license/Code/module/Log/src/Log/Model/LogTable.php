<?php
namespace Log\Model;

use Zend\Paginator\Paginator;

use Zend\Paginator\Adapter\DbSelect;

use Zend\Db\ResultSet\ResultSet;

use Zend\Db\Sql\Select;

use Zend\Db\TableGateway\TableGateway;

class LogTable
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tg)
	{
		$this->tableGateway = $tg;
	}
	
	public function fetchAll(array $params = null)
	{
		if(!empty($params)){
			$paginated = isset($params['paginated'])?$params['paginated']:null;
			$where = isset($params['where'])?$params['where']:null;
			$order = isset($params['order'])?$params['order']:null;
			$join = isset($params['join'])?$params['join']:null;
			$group = isset($params['group'])?$params['group']:null;
			$columns = isset($params['columns'])?$params['columns']:null;
			$limit = isset($params['limit'])?$params['limit']:null;
			
			if($paginated){
				$select = new Select();
				$select->from(array('t'=>'lic_log'));
				if($where != null)
					$select->where($where);
				
				if($order != null)
					$select->order($order);
				
				if($join != null && !empty($join))
					$select->join($join['name'], $join['on'],$join['columns'],$select::JOIN_INNER);	
				
				if($group != null)
					$select->group($group);
				
				$result = new ResultSet();
				$result->setArrayObjectPrototype(new Log());
				
				$paginatorAdapter = new DbSelect(
						$select, 
						$this->tableGateway->getAdapter(),
						$result
						);
				
				$paginator = new Paginator($paginatorAdapter);
				return $paginator;
			}
			
			$resultSet = $this->tableGateway->select(function(Select $select) use($where,$order,$join,$group,$columns,$limit){
				if($where != null){
					$select->where($where);
				}
				if($order != null){
					$select->order($order);
				}
				if($join != null){
					$select->join($join['name'], $join['on'],$join['columns'],$select::JOIN_INNER);	
				}
				if($group != null){
					$select->group($group);
				}
				if($columns != null){
					$select->columns($columns);
				}
				if($limit != null){
					$select->limit($limit);
				}
			});
			return $resultSet;
		}else{
			return $this->tableGateway->select();
		}
	}
}