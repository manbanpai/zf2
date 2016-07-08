<?php
namespace MyAcl\Controller\Plugin;

use Zend\Db\Sql\Predicate;

use Zend\Filter\Word\SeparatorToSeparator;

use Zend\Mvc\Router\Http\RouteMatch;

use Zend\Filter\Word\DashToSeparator;

use Zend\Db\Sql\Sql;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

class MyAclPlugin extends AbstractPlugin
{
    protected $sesscontainer;    

    //获取session
    private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('login');
        }
        return $this->sesscontainer;
    }

    /**
    * 函数用途描述
    * 系统进程中监听该事件
    * 如果用户拥有该操作权限则继续执行
    * 如果没有提示无权限
    * @date: 2016年6月30日
    * @author: cuik
    * @param: object
    */
    public function doAuthorization($e,$sm)
    {
    	$sess = $this->getSessContainer();
    	
    	$adapter = $sm->get('Zend\Db\Adapter\Adapter');
    	
    	$roleId = 0;
    	
    	if($sess->offsetExists('_adminRoleId')){
    		$roleId = (int) $sess->offsetGet('_adminRoleId');
    	}
    	
    	if($roleId == 1)
    		$role = 'admin';
    	else if($roleId == 2)
    		$role = 'general';
    	else if($roleId == 3)
    		$role = 'auditor';
    	else if($roleId == 0)
    		$role = 'anonymous';
	    	
    	// 设置 ACL
    	$acl = new Acl();
    	$acl->deny(); // 设置默认状态为禁止访问
    	//$acl->allow(); // 或者设置默认为访问状态

    	# 添加角色，角色之间可以继承，例如“user”拥有“anonymous”的所有权限。
    	$acl->addRole(new Role('anonymous'));
    	$acl->addRole(new Role('general'),'anonymous');
    	$acl->addRole(new Role('auditor'),'anonymous');
    	$acl->addRole(new Role('admin'),'anonymous');
    	
        # 添加资源
        $acl->addResource('application'); // Application 模块
        $acl->addResource('system'); // System 模块
        $acl->addResource('ca');
        $acl->addResource('log');
        $acl->addResource('member');
        $acl->addResource('base');
        $acl->addResource('license');

        ################ 设置权限 #######################
        // $acl->allow('角色', '资源', '控制器:方法');
        
        $acl->allow('anonymous','application','login:index');
        
        if($roleId){
	        $rs = $this->select($adapter, 'lic_user_role', array('id'=>(int)$roleId));
	
	        $aclString = (isset($rs) && !empty($rs))?$rs['acl']:"";
	        
	        $aclArray = array_filter(explode(',',$aclString));
	        
	       	$acl->allow($role, 'application', 'index:index');
	       	$acl->allow($role, 'application', 'index:welcome');
	       	$acl->allow($role, 'application', 'login:out');
			
			$p = $this->getPath($e);
			
			$row = $this->select($adapter, 'lic_user_menu',array('controller'=>$p['controller']));
			if($row['display'] == 'Y'){
			
    			if(isset($p['action'])){
    			    $a = explode('_',$p['action']);
    			    if(is_array($a) && $a[0] == 'acl'){
    			        $acl->allow($role,$p['module'],$p['controller'].':'.$p['action']);
    			    }
    			}
    			
    	        foreach($aclArray as $a){
    	        	if(strpos($a, '_')){
    	        		$tmp = explode('_',$a);
    	        		if($tmp[1] == 'index'){
    	        			$where = array('acl'=>$a);
    	        			$permi = $this->select($adapter, 'lic_user_menu',$where);
    	        			
    	        			if(isset($permi['module']) && !empty($permi['module'])){
    	        				$filter = new SeparatorToSeparator('_',':');
    	        				$url = $filter->filter($permi['acl']);
    	        				$acl->allow($role, $permi['module'], $url);
    	        				//echo $role.'=='.$permi['module'].'=='.$url."<br>";
    	        			}
    	        		}else{
    	        			$where = array('operation'=>$a);
    	        			$permi = $this->select($adapter, 'lic_user_menu',$where,
    	        					array(
    	        							'name'=>array('p'=>'lic_user_permi'),
    	        							'on'=>'t.id=p.menu_id',
    	        							'columns'=>array('operation'=>'operation'),
    	        					));
    	        			
    	        			if(isset($permi['module']) && !empty($permi['module'])){
    	        				$filter = new SeparatorToSeparator('_',':');
    	        				$url = $filter->filter($permi['operation']);
    	        				$acl->allow($role, $permi['module'], $url);
    	        				//echo $role.'=='.$permi['module'].'=='.$url."<br>";
    	        			}
    	        		}
    	        	}else{
    	        		$where = array('acl'=>$a);
    	        		$permi = $this->select($adapter, 'lic_user_menu',$where);
    	        		
    	        		if(isset($permi['module']) && !empty($permi['module'])){
    	        			$filter = new SeparatorToSeparator('_',':');
    	        			$url = $filter->filter($permi['acl']);
    	        			$acl->allow($role, $permi['module'], $url);
    	        		}
    	        	}
    	        }
			}
        }
        
        $path = $this->getPath($e);
       
        if (!$acl->isAllowed($role, $path['module'],$path['controller'].':'. $path['action'])){
        	if($role == 'anonymous'){
        		$this->getController()->redirect()->toRoute('application');
        	}
        	echo "<div class='container'>
		            	<h1><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true' style='color:red'></span>
		            		您没有该操作权限！请联系管理员授权.
		            	</h1>
		        	</div>"; 
        	$e->stopPropagation();
        }
        
    }
    
    /**
    * 函数用途描述
    * 该方法返回一个有模块、控制器、操作组成的数组
    * @date: 2016年6月30日
    * @author: cuik
    * @param: Object
    * @return: array
    */
    public function getPath($e){
    	$controller = $e->getTarget();
    	$controllerClass = get_class($controller);
    
    	$moduleName = strtolower(substr($controllerClass, 0, strpos($controllerClass, '\\')));
    	$routeMatch = $e->getRouteMatch();
    
    	$actionName = strtolower($routeMatch->getParam('action', 'not-found')); // get the action name
    	$controllerName = $routeMatch->getParam('controller', 'not-found');     // get the controller name
    	$cname = explode('\\', $controllerName);
    	$cn = array_pop($cname);
    	$controllerName = strtolower($cn);
    	return array('module'=>$moduleName,'controller'=>$controllerName,'action'=>$actionName);
    }
    
    /**
    * 函数用途描述
    * 数据库查询方法
    * 返回单挑记录数据
    * @date: 2016年6月30日
    * @author: cuik
    * @param: object string
    * @return: array
    */
    public function select($adapter,$table,$where=null,$join=null,$combination = Predicate\PredicateSet::OP_AND)
    {
    	if($table){
    		$sql = new Sql($adapter);
    		$select = $sql->select();
    		$select->from(array('t'=>$table));
    		if($where!=null)
    			$select->where($where,$combination);
    		if($join !=null)
    			$select->join($join['name'], $join['on'],$join['columns'],$select::JOIN_INNER);
    		
    		$statement = $sql->prepareStatementForSqlObject($select);
    		$results = $statement->execute();
    		$row = $results->current();
			return $row;
    	}
    }
}