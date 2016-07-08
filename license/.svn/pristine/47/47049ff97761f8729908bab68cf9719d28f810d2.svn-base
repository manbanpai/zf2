<?php
namespace Ca\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ca\Form\CertficateIssuerForm;
use Ca\Model\CertficateIssuer;
use Ca\Form\CertficateForm;
use Ca\Model\Certficate;
use Ca\Cert\Cert;

class CertController extends AbstractActionController
{
    const CA_PATH = 'data/ca/';
    const CA_NAME_PREFIX = 'ca';
    const CA_PUBLIC_KEY_PREFIX = 'public';
    const CA_PRIVATE_KEY_PREFIX = 'private';
    const CA_EXT = '.pem';
        
    protected $certficateIssuerTable;
    protected $certficateTable;
        
    public function getCertficateIssuerTable()
    {
        if (!$this->certficateIssuerTable){
            $sm = $this->getServiceLocator();
            $this->certficateIssuerTable = $sm->get('Ca\Model\CertficateIssuerTable');
        }
        return $this->certficateIssuerTable;
    }
    
    public function getCertficateTable()
    {
        if (!$this->certficateTable){
            $sm = $this->getServiceLocator();
            $this->certficateTable = $sm->get('Ca\Model\CertficateTable');
        }
        return $this->certficateTable;
    }
    
    public function indexAction()
    {
        $page = (int)$this->params()->fromRoute('page', 1);        
        $paginator = $this->getCertficateTable()->getPaginator($page, 10);
        $view = new ViewModel();
        $issuerId = $this->getCertficateIssuerTable()->getCertficateIssuerId();
        $view->setVariable('issuerId', $issuerId);
        $view->setVariable('paginator', $paginator);
        return $view;
    }
    
    public function addAction()
    {
        $form = new CertficateForm();
        $request = $this->getRequest();
        if ($request->isPost()){
            $certficate = new Certficate();
            $form->setInputFilter($certficate->getInputFilter());
            $postData = $request->getPost();
            $form->setData($postData);
            $this->getCertficateTable()->beginTransaction();
            try {
                if (!($form->isValid())){
                    throw new \Exception();
                }
                
                $certficate->exchangeArray($form->getData());
                if (!($lastId = $this->getCertficateTable()->saveCertficate($certficate))){
                    throw new \Exception();
                }
                
                $serial = $this->getCertficateTable()->getSerialNumber();
                $privfile = self::CA_PATH.self::CA_PRIVATE_KEY_PREFIX.'_'.sha1($serial).self::CA_EXT;
                $cafile = self::CA_PATH.self::CA_NAME_PREFIX.'_'.sha1($serial).self::CA_EXT;                        
                $cert = new Cert();
                $cert->setPrivateFile($privfile);
                $cert->setCaFile($cafile);
                $cert->setDays((int)$postData['valid_days']);
                $cert->setSerialNumber($serial);
                $cert->setDn($form->getData());
                
                if (!file_exists(self::CA_PATH)){
                    @mkdir(self::CA_PATH, 0777, true);
                }
                
                if (!($cert->certificate())){
                    throw new \Exception();
                }
                
                if (!(file_exists($cafile))){
                    throw new \Exception();
                }
                
                $dateArr = $this->getCertficateTable()->getCertDate($cafile);                                
                $updateData = array(
                    'begin_time' => $dateArr['s'],
                    'end_time' => $dateArr['e'],
                    'cert_savepath' => $cafile,
                    'sha1file' => sha1_file($cafile),
                    'serial' => $this->getCertficateTable()->serialNumberToHex($serial),
                );
                
                if (!$this->getCertficateTable()->updateCertficate($updateData, $lastId)){
                    throw new \Exception();
                }
                
                $this->getCertficateTable()->commit();
                return $this->redirect()->toRoute('ca', array(
                    'controller' => 'cert'
                ));
            }catch (\Exception $e){
                @unlink($cafile);
                $this->getCertficateTable()->rollback();
            }
        }
        $issuerId = $this->getCertficateIssuerTable()->getCertficateIssuerId();
        if (empty($issuerId)){
            $url = $this->url()->fromRoute('ca', array(
                'controller'=>'cert',
                'action'=>'addIssuer',                
            ));
            echo '<script type="text/javascript">alert("请先添加颁发者！");window.location.href="'.$url.'";</script>';
            exit();
        }
        $certficateIsser = $this->getCertficateIssuerTable()->getCertficateIssuer($issuerId);
        $form->setData(array(
            'issuer_id'=>$issuerId,
            'user_country_name'=>$certficateIsser->issuer_country_name,
            'user_state_or_province_name'=>$certficateIsser->issuer_state_or_province_name,
            'user_locality_name'=>$certficateIsser->issuer_locality_name,
            'user_organization_name'=>$certficateIsser->issuer_organization_name,
            'user_organizational_unit_name'=>$certficateIsser->issuer_organizational_unit_name,
            'user_common_name'=>$certficateIsser->issuer_common_name,
            'user_email_address'=>$certficateIsser->issuer_email_address,
            'user_surname'=>$certficateIsser->issuer_surname,
        ));        
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }
    
    /**
     * 增加证书颁发者
     * @throws \Exception
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function addIssuerAction()
    {
        $form = new CertficateIssuerForm();        
        $request = $this->getRequest();
        if ($request->isPost()){
            $certficateIssuer = new CertficateIssuer();
            $form->setInputFilter($certficateIssuer->getInputFilter());
            $postData = $request->getPost();
            $form->setData($postData);
            
            if ($form->isValid()){
                $certficateIssuer->exchangeArray($form->getData());
                $this->getCertficateIssuerTable()->saveCertficateIssuer($certficateIssuer);
                return $this->redirect()->toRoute('ca', array(
                    'controller' => 'cert',
                ));
            }                       
        }
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }    
       
    /**
     * 修改证书颁发者
     * @throws \Exception
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function editIssuerAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (!$id){
            return $this->redirect()->toRoute('ca', array(
                'controller' => 'cert',
                'action' => 'addIssuer'
            ));
        }
        try {
            $certficateIssuer = $this->getCertficateIssuerTable()->getCertficateIssuer($id);
        }catch (\Exception $e){
            return $this->redirect()->toRoute('ca', array(
                'controller' => 'cert'
            ));
        }
        $form = new CertficateIssuerForm();
        $form->bind($certficateIssuer);
        $form->get('submit')->setAttribute('value', '修改');
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setInputFilter($certficateIssuer->getInputFilter());
            $postData = $request->getPost();
            $form->setData($postData);
            
            if ($form->isValid()){
                $this->getCertficateIssuerTable()->saveCertficateIssuer($form->getData());
                return $this->redirect()->toRoute('ca', array(
                    'controller' => 'cert'
                ));
            }            
        }        
        $view = new ViewModel();
        $view->setVariable('form', $form);
        $view->setVariable('id', $id);
        return $view;
    }
    
    /**
     * 公钥下载
     * @return \Zend\Stdlib\ResponseInterface
     */
    public function certdownAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $row = $this->getCertficateTable()->getCertficate($id);
        ob_start();
        $filename = self::CA_NAME_PREFIX.'_'.sha1(hexdec($row->serial)).self::CA_EXT;
        $filepath = self::CA_PATH.$filename;
        header( "Content-type:  application/octet-stream ");
        header( "Accept-Ranges:  bytes ");
        header( "Content-Disposition:  attachment;  filename = $filename");        
        $size=readfile($filepath);
        header( "Accept-Length: " .$size);
        return $this->response;
    }
    
    /**
     * 私钥下载
     * @return \Zend\Stdlib\ResponseInterface
     */
    /*
    public function aclPkeydownAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $row = $this->getCertficateTable()->getCertficate($id);
        ob_start();
        $filename = self::CA_PRIVATE_KEY_PREFIX.'_'.sha1(hexdec($row->serial)).self::CA_EXT;
        $filepath = self::CA_PATH.$filename;
        header( "Content-type:  application/octet-stream ");
        header( "Accept-Ranges:  bytes ");
        header( "Content-Disposition:  attachment;  filename = $filename");
        $size=readfile($filepath);
        header( "Accept-Length: " .$size);
        return $this->response;
    }
    */
}
