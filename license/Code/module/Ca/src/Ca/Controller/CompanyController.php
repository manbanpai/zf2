<?php
namespace Ca\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ca\Form\CompanyForm;
use Ca\Model\Company;
use Ca\File\File;
use Zend\Form\Form;


class CompanyController extends AbstractActionController
{
    protected $companyTable;
    protected $areaTable;
    
    public function getCompanyTable()
    {
        if (!$this->companyTable){
            $sm = $this->getServiceLocator();
            $this->companyTable = $sm->get('Ca\Model\CompanyTable');
        }
        return $this->companyTable;
    }
    
    public function getAreaTable()
    {
        if (!$this->areaTable){
            $sm = $this->getServiceLocator();
            $this->areaTable = $sm->get('Ca\Model\AreaTable');
        }
        return $this->areaTable;
    }
        
    public function indexAction()
    {
        $view = new ViewModel();
        
        $count = $this->getCompanyTable()->count();
        $data = $this->getCompanyTable()->getOne();
        if (!empty($data)){
            $data = $data[0];
        }
        $view->setVariable('count', $count);
        $view->setVariable('data', $data);             
        return $view;
    }
    
    public function addAction()
    {        
        $areaRes = $this->getAreaTable()->getArea();
        $areaArr = array('请选择');
        foreach ($areaRes as $row){
            $areaArr[$row->area_id] = $row->title;
        }
        $form = new CompanyForm();
        $form->elementProvince($areaArr);
        $form->elementCity(array('请选择'));
        $form->elementArea(array('请选择'));
        $request = $this->getRequest();
        
        if ($request->isPost()){
            $company = new Company();
            $form->setInputFilter($company->getInputFilter());
            
            $files = $request->getFiles();
            $upload = new File();
            $res = $upload->filter($files['logo']);
            $tmplogo = str_replace('\\', '/', $res['tmp_name']);
            
            $postData = $request->getPost();
            $postData['logo'] = $tmplogo;
            
            $form->setData($postData);
            if ($form->isValid()){
                $company->exchangeArray($form->getData());                
                $this->getCompanyTable()->saveCompany($company);
                return $this->redirect()->toRoute('ca', array(
                    'controller' => 'company',
                ));
            }
        }        
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id){
            return $this->redirect()->toRoute('ca', array(
                'controller' => 'company',
                'action' => 'add',
            ));
        }
        try {
            $company = $this->getCompanyTable()->getCompany($id);
        }catch (\Exception $e){
            return $this->redirect()->toRoute('ca', array(
                'controller' => 'company',
            ));
        }
        $form = new CompanyForm();
        $form->elementProvince($this->getAreaTable()->getAreaToSelect(), $company->province);
        if ($company->province==0){
            $company->province = -1;
        }
        $form->elementCity($this->getAreaTable()->getAreaToSelect($company->province), $company->city);
        if ($company->city==0){
            $company->city = -1;
        }
        $form->elementArea($this->getAreaTable()->getAreaToSelect($company->city),$company->area);
        $form->bind($company);
        $form->get('submit')->setAttribute('value', '修改');
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setInputFilter($company->getInputFilter());
            
            $files = $request->getFiles();
            $upload = new File();
            $res = $upload->filter($files['logo']);
            $tmplogo = str_replace('\\', '/', $res['tmp_name']);
            
            $postData = $request->getPost();
            $postData['logo'] = $tmplogo;
            
            $form->setData($postData);
            //try {
                if ($form->isValid()){
                    $this->getCompanyTable()->saveCompany($form->getData());
                    return $this->redirect()->toRoute('ca', array(
                        'controller' => 'company',
                    ));
                }/* else{
                    throw new \Exception();
                } */
            //}catch (\Exception $e){
                //echo $e->__toString();
            //}            
        }        
        $view = new ViewModel();
        $view->setVariable('form', $form);
        $view->setVariable('id', $id);
        return $view;
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $view = new ViewModel();
        $view->setTemplate(true);
        if ($this->getCompanyTable()->deleteCompany($id) > 0){
            return $this->redirect()->toRoute('ca', array(
                'controller' => 'company',
            ));
        }else{
            throw new \Exception('Delete failed');
        }
    }
    
    public function aclCityAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()){
            $request = $this->getRequest();
            $data = $request->getPost();
            $id = (int)$data->id;
            $str = '<select name="city" id="city" onchange="getArea()" class="form-control">';
            $str .= '<option value=0>请选择</option>';
            if ($id){
                $data = $this->getAreaTable()->getArea($id);
                foreach ($data as $row){
                    $str .= '<option value="'.$row->area_id.'">';
                    $str .= $row->title;
                    $str .= '</option>';
                }
            }
            $str .= '</select>';            
            $arr = array(
                'city'=>$str,
                'area'=>'<select name="area" id="area" class="form-control"><option value=0>请选择</option></select>',
            );
            $str = json_encode($arr);
            echo $str;
            return $this->response;
        }
    }
    
    public function aclAreaAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()){
            $request = $this->getRequest();
            $data = $request->getPost();
            $id = (int)$data->id;
            $str = '<select name="area" id="area" class="form-control">';
            $str .= '<option value=0>请选择</option>';
            if ($id){
                $data = $this->getAreaTable()->getArea($id);
                foreach ($data as $row){
                    $str .= '<option value="'.$row->area_id.'">';
                    $str .= $row->title;
                    $str .= '</option>';
                }
            }
            $str .= '</select>';
            echo $str;
            return $this->response;
        }
    }
}