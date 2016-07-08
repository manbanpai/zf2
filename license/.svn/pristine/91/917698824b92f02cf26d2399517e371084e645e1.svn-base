<?php
namespace System\Model;

use Zend\InputFilter\InputFilter;

use Zend\InputFilter\InputFilterInterface;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Validator\NotEmpty;
use Zend\Validator\Digits;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;

class User implements InputFilterAwareInterface{
	public $id;
	public $username;
	public $password;
	public $password_rand;
	public $realname;
	public $tel;
	public $mobile;
	public $position;
	public $extension;
	public $role_id;
	public $email;
	public $qq; 
	public $last_login_ip;
	public $last_login_time;
	public $login_number;
	public $online_status;
	public $login_updatetime;
	public $password_status;
	public $update_password_time;
	public $password_reset_status;
	public $password_expire_date;
	public $createtime; 
	public $role_name;
	
	protected $inputFilter;
	
	//对数组数据进行转换或都说是提取数组数据
	public function exchangeArray($data)
	{
		$this->id = (!empty($data['id']))?$data['id']:'';
		$this->username = (!empty($data['username']))?$data['username']:'';
		$this->password = (!empty($data['password']))?$data['password']:'';
		$this->password_rand = (!empty($data['password_rand']))?$data['password_rand']:'';
		$this->realname = (!empty($data['realname']))?$data['realname']:'';
		$this->tel = (!empty($data['tel']))?$data['tel']:'';
		$this->mobile = (!empty($data['mobile']))?$data['mobile']:'';
		$this->position = (!empty($data['position']))?$data['position']:'';
		$this->extension = (!empty($data['extension']))?$data['extension']:'';
		$this->role_id = (!empty($data['role_id']))?$data['role_id']:'';
		$this->email = (!empty($data['email']))?$data['email']:'';
		$this->qq = (!empty($data['qq']))?$data['qq']:'';
		$this->last_login_ip = (!empty($data['last_login_ip']))?$data['last_login_ip']:'';
		$this->last_login_time = (!empty($data['last_login_time']))?$data['last_login_time']:'';
		$this->login_number = (!empty($data['login_number']))?$data['login_number']:'';
		$this->online_status = (!empty($data['online_status']))?$data['online_status']:'N';
		$this->login_updatetime = (!empty($data['login_updatetime']))?$data['login_updatetime']:'';
		$this->password_status = (!empty($data['password_status']))?$data['password_status']:'';
		$this->update_password_time = (!empty($data['update_password_time']))?$data['update_password_time']:'';
		$this->password_reset_status = (!empty($data['password_reset_status']))?$data['password_reset_status']:'';
		$this->password_expire_date = (!empty($data['password_expire_date']))?$data['password_expire_date']:'';
		$this->createtime = (!empty($data['createtime']))?$data['createtime']:'';
		$this->role_name = (!empty($data['role_name']))?$data['role_name']:'';
	}
	
	//将类属性转化为一个关联数组，方便后续的使用
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('不使用');
	}
	
	// 获取收入类型过滤器，对指定的表单元素进行过滤
	public function getInputFilter()
	{
		if(!$this->inputFilter){
			//实例化一个InputFilter过滤器
			$inputFilter = new InputFilter();
			
			$inputFilter->add(array(
				'name'=>'id',
				'required'=>true,
				'filters'=>array(
					array('name'=>'Int'),	
					)	
				));
			
			$inputFilter->add(array(
				'name'=>'username',
				'required'=>true,
				'filters'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding'=>'UTF-8',
							'min'=>6,
							'max'=>20,
						    'messages' => array(
						        StringLength::TOO_SHORT => '字符太少，请输入6个字符。',
						        StringLength::TOO_LONG => '字符太多，请输入20个字符。'
						    )
						)
					),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
					/* array(
					 'name'	=> 'Db\NoRecordExists',
						'options' => array(
							'table' => 'lic_user',
							'field' => 'username',
							'adapter' => $this->adapter,
						),
					), */
				)
			));
			
			$inputFilter->add(array(
				'name'=>'password',
				'required'=>false,
				'validators'=>array(
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding'=>'UTF-8',
							'min'=>6,
							'max'=>32,
						    'message'=>array(
						        StringLength::TOO_SHORT => '字符太少，请输入6个字符以上。',
						        StringLength::TOO_LONG => '字符太多，请输入62个字符以内。'
						    ),
							)	
						),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
					),	
				));
			
			$inputFilter->add(array(
				'name'=>'role_id',
				'required'=>true,
				'validators'=>array(
					/* array(
						'name'=>'NoRecordExists'
						'options'=>	
						)	*/
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
					) 
				));
			
			$inputFilter->add(array(
				'name'=>'realname',
				'required'=>false,
				'filter'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
						'name'=>'StringLength',
						'options'=>array(
								'encoding'=>'UTF-8',
								'min'=>0,
								'max'=>128,
						)
					),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
				)
				));
			
			$inputFilter->add(array(
				'name'=>'tel',
				'required'=>false,
				'filter'=>array(
					array('name'=>'Digits')
					),
				'validators'=>array(
					array(
					    'name'=>'Digits',
					    'options'=>array(
					        'message'=>array(
					            Digits::NOT_DIGITS =>'不是数字。'
					        )
					    )
					),
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding' => 'UTF-8',
							'min'=>7,
							'max'=>8,
						    'messages' => array(
						        StringLength::TOO_SHORT => '字符太少，请输入7个字符。',
						        StringLength::TOO_LONG => '字符太多，请输入8个字符。'
						    )
						)		
					),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
					)	
				));
			
			$inputFilter->add(array(
				'name'=>'mobile',
				'required'=>true,
				'filter'=>array(
					array('name'=>'Digits')
					),
				'validators'=>array(
					array(
					    'name'=>'Digits',
					    'options'=>array(
					        'message'=>array(
					            Digits::NOT_DIGITS =>'不是数字。'
					        )
					    )
					),
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding' => 'UTF-8',
							'min'=>11,
							'max'=>11,
						    'messages' => array(
						        StringLength::TOO_SHORT => '字符太少，请输入11个字符。',
						        StringLength::TOO_LONG => '字符太多，请输入11个字符。'
						    )
						)
					),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
				)
				));
			
			$inputFilter->add(array(
				'name'=>'postion',
				'required'=>false,
				'filter'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding' => 'UTF-8',
							'min'=>0,
							'max'=>128,
					        'message'=>array(
					           StringLength::TOO_SHORT => '字符太少，请输入0个字符。',
					           StringLength::TOO_LONG => '字符太多，请输入128个字符。'
						    )
						)
					),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
				)
			));
			
			$inputFilter->add(array(
				'name'=>'extension',
				'required'=>false,
				'filter'=>array(
					array('name'=>'Digits')
				),
				'validators'=>array(
					array(
					    'name'=>'Digits',
					    'options'=>array(
					        'message'=>array(
					            Digits::NOT_DIGITS =>'不是数字。'
					        )
					    )
					),
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding' => 'UTF-8',
							'min'=>0,
							'max'=>16,
						    'message'=>array(
						        StringLength::TOO_SHORT => '字符太少，请输入0个字符。',
						        StringLength::TOO_LONG => '字符太多，请输入16个字符。'
						    )
						)
					),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
				)
			));
			
			$inputFilter->add(array(
				'name'=>'email',
				'required'=>true,
				'filter'=>array(
					array('name'=>'StripTags'),
					array('name'=>'StringTrim'),
				),
				'validators'=>array(
					array(
                        'name' => 'EmailAddress',
                        'options' => array(
                            'messages' => array(
                                EmailAddress::INVALID => '无效的类型。',
                                EmailAddress::INVALID_FORMAT => '输入不是有效的电子邮件地址。',
                                EmailAddress::INVALID_HOSTNAME => '主机名不是一个有效的主机名的电子邮件地址',
                                //EmailAddress::INVALID_MX_RECORD => '主机名似乎没有任何有效的电子邮件地址或一个MX记录',
                                //EmailAddress::INVALID_SEGMENT => '',                                
                                //EmailAddress::DOT_ATOM => '',
                                //EmailAddress::QUOTED_STRING => '',
                                //EmailAddress::INVALID_LOCAL_PART => '',
                                EmailAddress::LENGTH_EXCEEDED => '输入超过允许长度',                                
                            )
                        )
                    ),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding' => 'UTF-8',
							'min'=>0,
							'max'=>128,
						    'messages' => array(
						        StringLength::TOO_SHORT => '字符太少，请输入5个字符。',
						        StringLength::TOO_LONG => '字符太多，请输入128个字符。'
						    )
						)
					),
				)
			));
			
			$inputFilter->add(array(
				'name'=>'qq',
				'required'=>false,
				'filter'=>array(
					array('name'=>'Digits'),
				),
				'validators'=>array(
					array(
					    'name'=>'Digits',
					    'options'=>array(
					        'message'=>array(
					            Digits::NOT_DIGITS =>'不是数字。',
					        )
					    )
					),
					array(
						'name'=>'StringLength',
						'options'=>array(
							'encoding' => 'UTF-8',
							'min'=>5,
							'max'=>13,
						    'messages' => array(
						        StringLength::TOO_SHORT => '字符太少，请输入5个字符。',
						        StringLength::TOO_LONG => '字符太多，请输入13个字符。'
						    )
						)
					),
				    array(
				        'name'=>'NotEmpty',
				        'options'=>array(
				            'message'=>array(
				                NotEmpty::IS_EMPTY => '不能为空。',
				            ),
				        )
				    ),
				)
			));
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
}