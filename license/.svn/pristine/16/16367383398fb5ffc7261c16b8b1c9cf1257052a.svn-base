<?php
namespace Application\Controller;

use Zend\Db\Sql\Sql;

use Zend\Session\Container;

use Application\Model\User;

use Application\Form\UserForm;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

class LoginController extends AbstractActionController
{
	public function indexAction()
	{
		$form = new UserForm();
		$request  = $this->getRequest();
		if($request->isPost()){
			$user = new User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()){
				$user->exchangeArray($form->getData());
				$data = $this->select('lic_user', array('username'=>$user->username));
				if(!$data){
					//用户不存在！
					return $this->redirect()->toRoute('home');
				}else if($this->validPassword($user->password,$data['password_rand']) != $data['password']){
					//密码错误
					$flag = $this->select('lic_user_loginrecord',array('user_id'=>$data['id']));
					if(!$flag){
						$values = array(
								'user_id'=>$data['id'],
								'place'=>'',
								'ip'=>'127.0.0.1',
								'create_time'=>time(),
								'lock_time'=>0,
								'login_error_number'=>1,
								);
						$this->insert('lic_user_loginrecord', $values);
					}else{
						if($flag->lock_time ==0){
							if($flag['login_error_number'] == 5){
								$values = array(
									'lock_time'=>time()+10*60,
								);
							}else{
								$values = array(
									'login_error_number'=>$flag['login_error_number']+1,
								);
							}
							$this->update('lic_user_loginrecord', $values,array('id'=>$flag['id']));
						}
					}
					return $this->redirect()->toRoute('home');
				}else if($this->getUserRoleStatus($data['role_id']) === 'N') {
                   	//此角色已被禁用！;
                   	return $this->redirect()->toRoute('home');
				}else{
					//查看loginrecord表中是否有当前角色数据
					$flag = $this->select('lic_user_loginrecord', array('user_id'=>$data['id']));
					if($flag){
						if(isset($flag['lock_time']) && $flag['lock_time'] < time()){
							$this->delete('lic_user_loginrecord',array('id'=>$flag['id']));
						}else{
							return $this->redirect()->toRoute('home');
						}
					}
					$session = new Container('login');
					$session->offsetSet('_adminUserId',$data['id']);
					$session->offsetSet('_adminUserName', $data['username']);
					$session->offsetSet('_adminRoleId', $data['role_id']);

					$values = array(
						'last_login_ip'=>'127.0.0.1',
						'last_login_time'=>time(),
						'login_number'=>1,
						'online_status'=>'Y',
						);
					$this->update('lic_user', $values,array('id'=>$data['id']));
					return $this->redirect()->toRoute('application',array('controller'=>'index','action'=>'index'));
				}
			}
		}		
		
		$view = new ViewModel();
		$view->setTerminal(true);
		$view->setVariable('form', $form);

		return $view;
	}
	
	public function outAction()
	{
		$session = new Container('login');
		if($session->offsetExists('_adminRoleId') && $session->offsetExists('_adminUserId')){
			$this->update('lic_user', array('online_status'=>'N'),array('id'=>$session->offsetExists('_adminUserId')));
			$session->offsetUnset('_adminRoleId');
			$session->offsetUnset('_adminUserId');
			$this->redirect()->toRoute('application');
		}
	}
	
	public function getUserRoleStatus($id){
		
		$id = (int) $id;
		if($id){
			$data = $this->select('lic_user_role', array('id'=>$id));
			if($data){
				return $data['status'];
			}
		}
	}
	
	public function validPassword($password,$rand)
	{
		if($password !=null && $rand != null){
			$md5 = md5(md5($password).$rand);
			$newPassword = substr($md5, 2,28);
			return $newPassword;
		}
	}
	
	public function delete($table,array $where=null)
	{
		if($table){
			$sql = new Sql($this->getAdapter());
			$delete = $sql->delete($table);
			if($where!=null && !empty($where)){
				$delete->where($where);
			}
			$statement = $sql->prepareStatementForSqlObject($delete);
			$id = $statement->execute();
			return $id;
		}
	}
	
	public function update($table,array $values,array $where=null)
	{
		if($table && !empty($values)){
			$sql = new Sql($this->getAdapter());
			$update = $sql->update($table);
			$update->set($values);
			if($where!=null && !empty($where)){
				$update->where($where);
			}
			$statement = $sql->prepareStatementForSqlObject($update);
			$id = $statement->execute();
			return $id;
		}
	}
	
	public function insert($table,array $values)
	{
		if($table && !empty($values)){
			$sql = new Sql($this->getAdapter());
			$insert = $sql->insert($table);
			$insert->values($values);
			$statement = $sql->prepareStatementForSqlObject($insert);
			$id = $statement->execute();
			return $id;
		}
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
			$row = $results->current();
			return $row;
		}
	}
	
	public function getAdapter()
	{
		$sm = $this->getServiceLocator();
		return $sm->get('Zend\Db\Adapter\Adapter');
	}
}