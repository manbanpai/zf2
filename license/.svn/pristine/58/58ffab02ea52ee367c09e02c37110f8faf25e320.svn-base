<?php
namespace Base\Model;

use Zend\Paginator\Paginator;

use Zend\Paginator\Adapter\DbSelect;

use Zend\Db\ResultSet\ResultSet;

use Zend\Db\Sql\Select;

use Zend\Db\TableGateway\TableGateway;

class ConfigTable
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tg)
	{
		$this->tableGateway = $tg;
	}
	
	public function deleteConfig($var)
	{
		$this->tableGateway->delete(array('variable'=>$var));
	}
	
	public function saveConfig(Config $config)
	{
		$data = array(
			'scope'=>$config->scope,
			'variable'=>$config->variable,
			'value'=>$config->value,
			'description'=>$config->description,		
		);
		
		$variable = (String) $config->variable;
		
		if(!$this->getConfig($variable)){
			$this->tableGateway->insert($data);
		}else{
			$this->tableGateway->update($data,array('variable'=>$variable));
		}
	}
	
	public function getConfig($var=null)
	{
		if($var != null){
			$rowset = $this->tableGateway->select(array('variable'=>$var));
			$row = $rowset->current();
			if(!$row)
				return false;
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
				$select->from(array('t'=>'lic_config'));
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