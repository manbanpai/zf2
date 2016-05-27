<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Db\Sql\Sql;

use Zend\Db\TableGateway\TableGateway;

use Application\Components\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends Controller
{
	public $menuTable;
	public $userTable;
	
    public function indexAction()
    {
    	$data = $this->select('lic_user_menu', array('display'=>'Y'));
    	
        $view = new ViewModel();
        $view->setTerminal('true');
        $variables = array(
        		'data'=>$data,
        		'username'=>$this->_adminUserName,
        		'id'=>$this->_adminUserId,
        		);
        $view->setVariables($variables);

        return $view;
    }
    
	public function select($table,$where)
	{
		if($table && $where){
			$sql = new Sql($this->getAdapter());
			$select = $sql->select();
			$select->from($table);
			$select->where($where);
			$statement = $sql->prepareStatementForSqlObject($select);
			$results = $statement->execute();
			
			return $results;
		}
	}
	
	public function getAdapter()
	{
		$sm = $this->getServiceLocator();
		return $sm->get('Zend\Db\Adapter\Adapter');
	}
}
