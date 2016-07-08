<?php
namespace Member\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Member\Form\LicenseForm;
use Member\Model\License;
use Member\Crypt\PrivateFile;
use Common\Crypt\Rsa\X509;
use Common\Crypt\Rsa\PrivateKey;
use Common\Crypt\Aes\Aes;
use Common\License\License as lic;
use Common\Crypt\Aes\Aesfile;
use Common\Crypt\Rsa\PrivateFile as privfile;
use Zend\Form\Element;
class LicenseController extends AbstractActionController
{
    protected $licenseTable;
    protected $certficateTable;    
    
    public function getLicenseTable()
    {
        if (!$this->licenseTable){
            $sm = $this->getServiceLocator();
            $this->licenseTable = $sm->get('Member\Model\LicenseTable');
        }     
        return $this->licenseTable;
    }
    
    public function getCertficateTable()
    {
        if (!$this->certficateTable){
            $sm = $this->getServiceLocator();
            $this->certficateTable = $sm->get('Member\Model\CertficateTable');
        }
        return $this->certficateTable;
    }
    
    /**
     * 列表显示
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        $now = time();
        //时间段
        $day = (int)$this->params()->fromQuery('day',0);        
        $dayArr = array();
        if ($day==7 || $day==15 || $day==30){
            $dayArr = array('expire_time<'.(($day*24*60*60)+$now));
        }      
        //有效/过期
        $expire = (int)$this->params()->fromQuery('expire',0);        
        $expArr = array();
        if ($expire==1){
            $expArr = array('expire_time>'.$now);
        }elseif ($expire==-1){
            $expArr = array('expire_time<'.$now);
        }
        $company_name = $this->params()->fromQuery('company_name', '');
        $comArr = array();
        if (!empty($company_name)){
            $comArr = array('company_name like "%'.$company_name.'"');
        }
        $page = (int)$this->params()->fromRoute('page', 1);
        
        $params = array();
        $params = array_merge($params,$expArr,$dayArr,$comArr);        
        $paginator = $this->getLicenseTable()->getPaginator($page, 10, $params);
        $view = new ViewModel();
        $view->setVariable('paginator', $paginator);
        $view->setVariable('company_name', $company_name);
        $view->setVariable('day', $day);
        $view->setVariable('expire', $expire);
        return $view;
    }
    
    /**
     * 添加
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        $now = time();
        //公司id
        $comid = $this->params()->fromQuery('comid',0);
        
        $form = new LicenseForm();
        $form->get('membercompany_id')->setAttribute('value', $comid);
        $certficate = $this->getCertficateTable();
        //$arr = $certficate->fetchAll();
        //$arr = $certficate->getSelect($arr);
        //$form->elementCertficate($arr);
        $request = $this->getRequest();
        if ($request->isPost()){            
            $license = new License();
            $form->setInputFilter($license->getInputFilter());
            $postData = $request->getPost();
            $form->setData($postData);
            if ($form->isValid()){
                if ($this->getCertficateTable()->getCount($postData['serial'])<=0){
                    throw new \Exception('没有此证书！');
                }
                $license->exchangeArray($form->getData());
                $license->create_time = $now;
                $license->expire_time = ($license->soft_valid_days*24*60*60) + $now;
                $license->serialnumber = $now;
                $license->client_info = json_encode(array(
                    'company_name' => $license->company_name,
                    'tel' => $license->tel,
                    'fax' => $license->fax,
                    'contact' => $license->contact,
                    'profession' => $license->profession,
                    'mobile' => $license->mobile,
                    'email' => $license->email,
                    'other' => $license->other,
                ));
                $this->getLicenseTable()->saveLicense($license);
                return $this->redirect()->toRoute('member', array(
                    'controller' => 'license',
                ));
            }
        }
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }
    
    public function editAction()
    {
        
    }
    
    /**
     * license详细
     * @return \Zend\View\Model\ViewModel
     */
    public function aclDetailsAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $license = $this->getLicenseTable()->getLicense($id);
        $form = new LicenseForm();
        $form->elementAudit();
        $form->get('submit')->setAttribute('value', '审核');
        $form->bind($license);
        $view = new ViewModel();
        $view->setVariable('form', $form);
        $view->setVariable('license', $license);
        return $view;
    }
    
    /**
     * 审核
     */
    public function auditAction()
    {
        $id = $this->params()->fromPost('id',0);
        $request = $this->getRequest();
        if ($request->isPost()){
            $this->getLicenseTable()->audit($id);        
        }
        $this->redirect()->toRoute('member', array(
            'controller' => 'license',
        ));
    }
    
    /**
     * 导入license未加密原文文件
     * @return \Zend\Stdlib\ResponseInterface
     */
    public function aclImportLicenseAction()
    {
        $status = false;
        $arr = array();
        $request = $this->getRequest();
        //license文件
        $licfile = $request->getFiles('lic_file');
        //证书序列号
        $cert = $request->getFiles('lic_cert');
        
        if ($licfile['error']!=0 || $cert['error']!=0){
            $arr['error'] = 'error';
            $arr['msg'] = '上传失败！';
        }else{
            $certData = file_get_contents($cert['tmp_name']);
            $x509 = new X509();
            $ca = $x509->x509Read($certData);
            $ca = $x509->x509Parse($ca);
            $serialNumber = $ca['serialNumber'];
            $serial = '0x'.dechex($serialNumber);
            $serialData = $this->getCertficateTable()->getCertId($serial);
            if (!empty($serialData)){
                $serialNumber = $serialData->id;
            }else{
                $serialNumber = 0;
            }
            //license文件
            $licenseStr = @file_get_contents($licfile['tmp_name']);            
            $lic = new lic();
            $licenseStr = $lic->getUnFormatLicense($licenseStr);
            //获取私钥进行解密license文件
            $privFile = new PrivateFile();
            $privFile->setFileName(hexdec($serial));
            $pemString = $privFile->getPemString();
            $privatekey = new PrivateKey($pemString);            
            //分段解密
            $pkfile = new privfile();
            $decrypted = $pkfile->blockDecrypt($privatekey,$licenseStr);
            
            $decrypted = json_decode($decrypted);
            $arr['info'] = $decrypted;
            $arr['cert_id'] = $serialNumber;//hidden int
            $arr['serial'] = $serial;//dex
            $arr['msg'] = '上传成功！';
            $arr['error'] = '';
        }
        echo json_encode($arr);
        return $this->response;
    }
    
    /**
     * license文件下载
     */
    public function licensedownAction()
    {      
        $id = (int)$this->params()->fromRoute('id', 0);
        $data = $this->getLicenseTable()->getLicense($id);
        if ($data->audit=='0'){            
            throw new \Exception('审核未通过，不允许下载！');
        }
        $licFile = new lic();
        $licFilePath = $licFile->getFilePath();
        $licFileName = $licFile->getFileName(hexdec($data->serial));
        
        //aes加密文件
        $aes = new Aes();
        //aes加密key        
        $licFile->setMaxClientNumber($data->max_client_number);
        $licFile->setSoftValideDays($data->soft_valid_days);
        
        //$licFile->setClientInfo($data->client_info);
        $clientInfo = json_decode($data->client_info);
        $licFile->setCompanyName($clientInfo->company_name);
        $licFile->setTel($clientInfo->tel);
        $licFile->setFax($clientInfo->fax);
        $licFile->setContact($clientInfo->contact);
        $licFile->setProfession($clientInfo->profession);
        $licFile->setMobile($clientInfo->mobile);
        $licFile->setEmail($clientInfo->email);
        $licFile->setOther($clientInfo->other);
        
        $licFile->setServerDomain($data->server_domain);
        $licFile->setServerCpuId($data->server_cpu_id);
        $licFile->setServerIp($data->server_ip);
        $licFile->setServerMac($data->server_mac);
        
        //aes加密文件
        $aes->setKey($licFile->getLicenseKey());
        
        $jsonLicense = $licFile->getLicense();
        
        $aesfile = new Aesfile();
        $aesLicense = $aesfile->encrypt($aes,$jsonLicense);        
        
        if (!file_exists($licFilePath)){
            if (!mkdir($licFilePath, 0777, true)){
                throw new \Exception('创建文件夹失败！');
            }
        }
        
        //rsa加密
        $privFile = new PrivateFile();
        $privFile->setFileName(hexdec($data->serial));
        $privatePemString = $privFile->getPemString();
        $privateKey = new PrivateKey($privatePemString);
        $pkfile = new privfile();
        $rsaLicense = $pkfile->blockEncrypt($privateKey, $aesLicense);
        
        $license = new lic();
        $licensefile = $license->getFormatLicense($rsaLicense);
                
        if (strlen($licensefile)==0){
            throw new \Exception('私钥加密失败！');
        }
        
        if (!file_put_contents($licFilePath.$licFileName, $licensefile)){
            throw new \Exception('写入文件失败！');
        }
        if (file_exists($licFilePath.$licFileName)){
            $this->down($licFilePath,$licFileName);
        }        
        return $this->response;
    }
    
    /**
     * 下载
     * @param string $filepath
     */
    public function down($filepath,$filename)
    {
        ob_start();        
        header( "Content-type:  application/octet-stream ");
        header( "Accept-Ranges:  bytes ");
        header( "Content-Disposition:  attachment;  filename = $filename");
        $size=readfile($filepath.$filename);
        header( "Accept-Length: " .$size);
    }
    
    /**
     * license申请
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function applyAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if (!$id){            
            return $this->redirect()->toRoute('member', array(
                'controller' => 'license',
            ));
        }
        try {
            $license = $this->getLicenseTable()->getLicense($id);
        }catch (\Exception $e){
            echo $e->__toString();
            return $this->redirect()->toRoute('member', array(
                'controller' => 'license',
            ));
        }
        $form = new LicenseForm();
        
        $clientInfo = json_decode($license->client_info);
        $license->company_name = $clientInfo->company_name;
        $license->tel = $clientInfo->tel;
        $license->fax = $clientInfo->fax;
        $license->contact = $clientInfo->contact;
        $license->profession = $clientInfo->profession;
        $license->mobile = $clientInfo->mobile;
        $license->email = $clientInfo->email;
        $license->other = $clientInfo->other;
        
        $form->get('company_name')->setAttribute('readonly', true);
        $form->get('tel')->setAttribute('readonly', true);
        $form->get('fax')->setAttribute('readonly', true);
        $form->get('contact')->setAttribute('readonly', true);
        $form->get('profession')->setAttribute('readonly', true);
        $form->get('mobile')->setAttribute('readonly', true);
        $form->get('email')->setAttribute('readonly', true);
        $form->get('other')->setAttribute('readonly', true);
        
        $form->get('server_domain')->setAttribute('readonly', true);
        $form->get('server_cpu_id')->setAttribute('readonly', true);
        $form->get('server_ip')->setAttribute('readonly', true);
        $form->get('server_mac')->setAttribute('readonly', true);
        
        $form->bind($license);
        $request = $this->getRequest();
        $now = time();
        $comid = $this->params()->fromQuery('comid',0);
        if ($request->isPost()){
            $license = new License();
            $form->setInputFilter($license->getInputFilter());
            $postData = $request->getPost();
            $postData['id'] = 0;
            $form->setData($postData);
            if ($form->isValid()){
                $license->exchangeArray((array)$form->getData());
                $license->create_time = $now;
                $license->expire_time = ($license->soft_valid_days*24*60*60) + $now;
                $license->serialnumber = $now;
                $license->client_info = json_encode(array(
                    'company_name' => $license->company_name,
                    'tel' => $license->tel,
                    'fax' => $license->fax,
                    'contact' => $license->contact,
                    'profession' => $license->profession,
                    'mobile' => $license->mobile,
                    'email' => $license->email,
                    'other' => $license->other,
                ));
                $this->getLicenseTable()->saveLicense($license);
                return $this->redirect()->toRoute('member', array(
                    'controller' => 'license',
                ));
            }
        }
        $view = new ViewModel();
        $view->setVariable('form', $form);
        $view->setVariable('id', $id);
        return $view;
    }
    
    /**
     * 删除
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($this->getLicenseTable()->deleteLicense($id)){
            return $this->redirect()->toRoute('member', array(
                'controller' => 'license',
            ));
        }
    }    
}

