<?php
namespace Log\Controller;

//use Zend\I18n\Filter\NumberFormat;
use \PHPExcel;

use PHPExcel_IOFactory;

use Zend\Db\Sql\Expression;

use Zend\Session\Container;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

class LogController extends AbstractActionController
{
	protected $logTable;
	protected $menuTable;
	protected $userTable;
	protected $session;
	
	public function getSess()
	{
		if(!$this->session){
			$this->session = new Container('login');
		}
		return $this->session;
	}
	
	//导出
	public function exportAction()
	{
		$sess = $this->getSess();
		$userId = $roleId = 0;
		
		if($sess->offsetExists('_adminUserId')){
			$userId = $sess->offsetGet('_adminUserId');
		}
		
		if($sess->offsetExists('_adminRoleId')){
			$RoleId = $sess->offsetGet('_adminRoleId');
		}
		
		$params = array();
		$params['where'] = array(
				'display'=>'1',
				"url!='application/index/welcome'",
				"url!='application/index/index'",
				"url!='log/log/index'",
		);
		
		if($RoleId != 1)
			$params['where']['user_id'] = $userId;
		
		$time = $this->params()->fromRoute('time',0);
		$user = $this->params()->fromRoute('user','N');
		$url = $this->params()->fromRoute('url',0);
		$ctime = $this->returnCtime($time);
		
		if($url != 'all'){
			$params['where']['url'] = str_replace('_', '/', $url);
		}
			
		if($time){
			$params['where'][] = "create_time>$ctime";
		}
		
		if($user != 'N'){
			$params['where']['user_id'] = $user;
		}
		
		$join = array('join'=>array(
				'name'=>array('u'=>'lic_user'),
				'on'=>'u.id = lic_log.user_id',
				'columns'=>array('username'=>'username'),
		));
		
		$data = $this->getLogTable()->fetchAll(array_merge($params,$join));
		$count = count($data);
		$data = iterator_to_array($data);
		
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1','序号')
		->setCellValue('B1','用户')
		->setCellValue('C1', '类型')
		->setCellValue('D1', '操作地址')
		->setCellValue('E1', '登录IP')
		->setCellValue('F1', '操作时间');
		
		for($i=0;$i<$count;$i++){
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.($i+2), $i+1)
			->setCellValue('B'.($i+2), $data[$i]->username)
			->setCellValue('C'.($i+2), $data[$i]->cate_name)
			->setCellValue('D'.($i+2), $data[$i]->url)
			->setCellValue('E'.($i+2), $data[$i]->ip)
			->setCellValue('F'.($i+2), date('Y-m-d H:i:s',$data[$i]->create_time));
		}
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.date('YmdHis',time()).'_log.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}
	
	//列表
	public function indexAction()
	{
		$sess = $this->getSess();
		$userId = $roleId = 0;
		$time90 = time()-90*24*3600;
		
		if($sess->offsetExists('_adminUserId')){
			$userId = $sess->offsetGet('_adminUserId');
		}
		
		if($sess->offsetExists('_adminRoleId')){
			$roleId = $sess->offsetGet('_adminRoleId');
		}
		
		$url = $time = $ctime = $user = 0;
		$params = array();
		
		$join = array('join'=>array(
				'name'=>array('u'=>'lic_user'),
				'on'=>'u.id = t.user_id',
				'columns'=>array('username'=>'username'),
		));
		
		
		$params['where'] = array(
				'display'=>'1',
				"url!='application/index/welcome'",
				"url!='log/log/index'",
				"create_time>$time90",
		);
		
		if($roleId != 1){
		    $params['where'] = array_merge($params['where'],array('user_id'=>$userId));
		}
		
		$request = $this->getRequest();
		
		if($request->isGet()){
			$url = $request->getQuery('url');
			$time = $request->getQuery('time');
			$user = $request->getQuery('user');
			
			$ctime = $this->returnCtime($time);
		
			if($url){
				$params['where']['url'] = $url;
			}
			
			if($time){
				$params['where'][] = "create_time>$ctime";
			}
			
			if($user){
				$params['where']['user_id'] = $user;
			}
		}

		//个人日志
		$pagin = array('paginated'=>true,'order'=>'id desc',);
		$paginator = $this->getLogTable()->fetchAll(array_merge($params,$join,$pagin));
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page',1));
		$paginator->setItemCountPerPage(10);
		
		//统计
		$data = $this->getLogTable()->fetchAll($params);
		$count = count($data);
		
		//return str
		$str = $this->returnStr($params,$count);
		
		//获取menu
		$menu = $this->getMenuTable()->fetchAll(array(
					'where'=>array('pid!=0','display'=>'Y'),
				));
		
		$users = $this->getUserTable()->fetchAll();

		$view = new ViewModel(array(
				'paginator'=>$paginator,
				'str'=>$str,
				'roleId'=>$roleId,
				'count'=>$count,
				'menu'=>$menu,
				'url'=>$url,
				'time'=>$time,
				'user'=>$user,
				'users'=>$users,
				));
		return $view;
	}
	
	/**
	* 函数用途描述
	* 返回一个时间戳
	* @date: 2016年6月30日
	* @author: cuik
	* @param: int
	* @return: int
	*/
	public function returnCtime($time)
	{
		if($time){
			switch ($time){
				case 1:
					return time()-24*3600;
				case 7:
					return time()-7*24*3600;
				case 30:
					return time()-30*24*3600;
				case 90:
					return time()-90*24*2600;
			}
		}else{
			return 0;
		}
	}
	
	/**
	* 函数用途描述
	* 用于数据统计
	* @date: 2016年6月30日
	* @author: cuik
	* @param: array,int
	* @return: String
	*/
	public function returnStr(array $params,$count)
	{
		$columns = array('columns'=>array('c'=>new Expression('COUNT(url)'),'url'));
		$group = array('group'=>'url');
		$arr = $this->getLogTable()->fetchAll(array_merge($params,$group,$columns));
		$str = '';
		foreach($arr as $a){
			$percent = round($a->c/$count,3)*100;
			$name = ucfirst($a->url);
			if($a->url == 'ca/cert/index')
				$str .= "{ name:'$name' , y: $percent, sliced: true, selected: true },";
			else
				$str .= "['$name',$percent],";
		} 
		return $str;
	}
	
	public function getLogTable()
	{
		if(!$this->logTable){
			$sm = $this->getServiceLocator();
			$this->logTable = $sm->get('Log\Model\LogTable');
		}
		return $this->logTable;
	}
	
	public function getMenuTable()
	{
		if(!$this->menuTable){
			$sm = $this->getServiceLocator();
			$this->menuTable = $sm->get('System\Model\MenuTable');
		}
		return $this->menuTable;
	}
	
	public function getUserTable()
	{
		if(!$this->userTable){
			$sm = $this->getServiceLocator();
			$this->userTable = $sm->get('System\Model\UserTable');
		}
		return $this->userTable;
	}
}