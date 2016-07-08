<?php
namespace License\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use License\Form\LicForm;
use Zend\View\Model\ViewModel;
use License\Model\LicInfo;
use License\Model\Lic;
use Common\License\License;
use Common\Crypt\Rsa\PublicKey;
use Common\Crypt\Rsa\PublicFile;
class LicController extends AbstractActionController 
{
    const TEMP_PATH = 'data/temp/';
    const TEMP_FILENAME = 'license.lic';
        
    public function aclIndexAction()
    {        
        $savepath = self::TEMP_PATH;
        $savename = self::TEMP_FILENAME;
        
        $form = new LicForm();
        $licInfo = new LicInfo();
        
        $ip = $licInfo->getIp();
        $cpuId = $licInfo->getCpuId();
        $mac = $licInfo->getMac();
        
        $form->setData(array(
            'server_ip' => $ip,
            'server_cpu_id' => $cpuId,
            'server_mac' => $mac,
        ));
        
        $request = $this->getRequest();
        if ($request->isPost()){
            $lic = new Lic();
            $form->setInputFilter($lic->getInputFilter());               
            $form->setData($request->getPost());
            if ($form->isValid()){                
                $postData = $form->getData();
                $license = new License();
                $license->setMaxClientNumber($postData['max_client_number']);
                $license->setSoftValideDays($postData['soft_valid_days']);
                //$license->setClientInfo($postData['client_info']);
                $license->setCompanyName($postData['company_name']);
                $license->setTel($postData['tel']);
                $license->setFax($postData['fax']);
                $license->setContact($postData['contact']);
                $license->setProfession($postData['profession']);
                $license->setMobile($postData['mobile']);
                $license->setEmail($postData['email']);
                $license->setOther($postData['other']);
                $license->setServerDomain($postData['server_domain']);
                $license->setServerCpuId($postData['server_cpu_id']);
                $license->setServerIp($postData['server_ip']);
                $license->setServerMac($postData['server_mac']);
                $cert = $request->getFiles('cert');
                if (!empty($cert['tmp_name']) && is_readable($cert['tmp_name'])){
                    $certData = file_get_contents($cert['tmp_name']);
                }
                $licenseStr = $license->getLicense();
                $publicKey = new PublicKey($certData);
                $publicfile = new PublicFile();
                $enLicenseStr = $publicfile->blockEncrypt($publicKey, $licenseStr);
                $enLicenseFile = $license->getFormatLicense($enLicenseStr);
                if (!file_exists($savepath)){
                    @mkdir($savepath,0777,true);
                }
                if(file_put_contents($savepath.$savename, $enLicenseFile)){
                    $this->down($savepath, $savename);
                    return $this->response;
                }else {
                    throw new \Exception('生成错误！');
                }
            }
        }
        if (file_exists($savepath.$savename)){
            $form->elementDownLic();
        }
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }
    
    public function aclDownlicenseAction()
    {
        $filepath = self::TEMP_PATH;
        $filename = self::TEMP_FILENAME;
        $file = $filepath.$filename;
        if (file_exists($file)){
            $this->down($filepath, $filename);
            $this->response;
            exit();
        }else{
            $this->redirect()->toRoute('lic',array('controller'=>'lic'));
        }
    }
    
    /**
     * 下载
     * @param string $filepath
     * @param string $filename
     */
    public function down($filepath,$filename)
    {
        $file = $filepath.$filename;       
        header( "Content-type:  application/octet-stream ");
        header( "Accept-Ranges:  bytes ");
        header( "Content-Disposition:  attachment;  filename = $filename");
        header( "Accept-Length: " .filesize($file));
        readfile($file);
    }
}