<?php
namespace MyAcl\Controller\Plugin;

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

    private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('login');
        }
        return $this->sesscontainer;
    }

    public function doAuthorization($e,$sm,$url)
    {
    	$route = array_filter(explode('/',trim($url,'/')));
    	$sess = $this->getSessContainer();
    	if($sess->offsetExists('_adminRoleId')){
    		
	    	$adapter = $sm->get('Zend\Db\Adapter\Adapter');
	    	$roleId = (int) $sess->offsetGet('_adminRoleId');
	    	if($roleId == 1)
	    		$role = 'admin';
	    	else if($roleId == 2)
	    		$role = 'general';
	    	else if($roleId == 3)
	    		$rolw = 'auditor';
	 		
	    	// 设置 ACL
	    	$acl = new Acl();
	    	$acl->deny(); // 设置默认状态为禁止访问
	    	//$acl->allow(); // 或者设置默认为访问状态
	    	
	    	# 添加角色，角色之间可以继承，例如“user”拥有“anonymous”的所有权限。
	    	$acl->addRole(new Role('general'));
	    	$acl->addRole(new Role('auditor'),  'general');
	    	$acl->addRole(new Role('admin'), 'auditor');
	    	
	    	
	
	        # 添加资源
	        $acl->addResource('application'); // Application 模块
	        $acl->addResource('system'); // Album 模块
	        $acl->addResource('ca');
	
	        ################ 设置权限 #######################
	        // $acl->allow('角色', '资源', '控制器:方法');
			
	        $rs = $this->select($adapter, 'lic_user_role', array('id'=>(int)$roleId));
	
	        //$acl->allow('anonymous', 'application', 'login:index');
	        
	        $aclString = (isset($rs) && !empty($rs))?$rs['acl']:"";
	        
	        $aclArray = array_filter(explode(',',$aclString));
	        
	        foreach($aclArray as $a){
	        	
	        	$permi = $this->select($adapter, 'lic_user_menu',
	        			array(
	        				'acl'=>$a,
	        				'operation'=>$a,		
	        			),
	        			array(
	        				'name'=>array('p'=>'lic_user_permi'),
	        				'on'=>'t.id=p.menu_id',
	        				'columns'=>array('operation'=>'operation'),
	        			),'OR');
	        	
	        	if($a == $permi['operation'] || $a == $permi['acl']){
	        		$filter = new DashToSeparator(':');
	        		$url = $filter->filter($permi['url']);
	        		$acl->allow($role, $permi['module'], $url); 
	        	}
	        }
				
	        if (!$acl->isAllowed($role, $route[0],$route[1].':'.'index')){
	        	echo "222";
	        }else{
	        	echo '44';
	        }
	        
	        //$route  = $e->getMatchedRouteName();
	        //print_r($route->params);
	        exit;
	        // Album -------------------------------->
	        $acl->allow('anonymous', 'album', 'album:index');
	        $acl->allow('anonymous', 'album', 'album:add');
	        $acl->deny('anonymous', 'album', 'album:hello');
	        $acl->allow('anonymous', 'album', 'album:view');
	        $acl->allow('anonymous', 'album', 'album:edit'); // 同样允许路由为 “zf2-tutorial.com/album/edit/1” 的访问
	        //$acl->deny('anonymous', 'Album', 'Album:song');
	
	        $controller = $e->getTarget();
	        echo $controller;exit;
	        $controllerClass = "<a href=\"http://www.php.net/get_class\">get_class</a>($controller)";
	        $moduleName = "<a href=\"http://www.php.net/strtolower\">strtolower</a>(<a href=\"http://www.php.net/substr\">substr</a>($controllerClass, 0, <a href=\"http://www.php.net/strpos\">strpos</a>($controllerClass, '\\')))";
	        $role = (! $this->getSessContainer()->role ) ? 'anonymous' : $this->getSessContainer()->role;
	        $routeMatch = $e->getRouteMatch();
			
	        $actionName = "<a href=\"http://www.php.net/strtolower\">strtolower</a>($routeMatch->getParam('action', 'not-found'))"; // 获取方法名
	        $controllerName = $routeMatch->getParam('controller', 'not-found');     // 获取控制器名
	        $controllerName = "<a href=\"http://www.php.net/strtolower\">strtolower</a>(<a href=\"http://www.php.net/array_pop\">array_pop</a>(<a href=\"http://www.php.net/explode\">explode</a>('\\', $controllerName)))";
	
	        /*
	          print '<br>$moduleName: '.$moduleName.'<br>';
	          print '<br>$controllerClass: '.$controllerClass.'<br>';
	          print '$controllerName: '.$controllerName.'<br>';
	          print '$action: '.$actionName.'<br>'; */
	
	        #################### 检查权限 ########################
	        if ( ! $acl->isAllowed($role, $route[0]?:'application',$route[1]?:'login'.':'.$route[2]?:'index')){
	            $router = $e->getRouter();
	            // $url    = $router->assemble(array(), array('name' => 'Login/auth')); // assemble a login route
	            $url    = $router->assemble("<a href=\"http://www.php.net/array\">array</a>(), <a href=\"http://www.php.net/array\">array</a>('name' => 'application')");
	            $response = $e->getResponse();
	            $response->setStatusCode(302);
	            // redirect to login page or other page.
	            $response->getHeaders()->addHeaderLine('Location', $url);
	            $e->stopPropagation();
	        }
    	}
    }
    
    public function select($adapter,$table,$where=null,$join=null,$combination = 'or')
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