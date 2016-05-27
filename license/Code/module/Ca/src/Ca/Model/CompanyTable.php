<?php
namespace Ca\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;

class CompanyTable extends AbstractTableGateway
{
    
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    /**
     * 数量
     * @return number
     */
    public function count()
    {
        return $this->tableGateway->select()->count();
    }
    
    /**
     * 获取最新一条数据
     * @return array
     */
    public function getOne()
    {
        $select = $this->tableGateway->getSql()->select();
        $select->order('id desc')->limit(1);
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet->toArray();
    }
    
    /**
     * 获取所有数据
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll()
    {
        return $this->tableGateway->select(function($select){
            return $select->order('id desc');
        });
    }
    
    /**
     * 通过id获取公司信息
     * @param int $id
     * @throws \Exception
     * @return array
     */
    public function getCompany($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id'=>$id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    /**
     * 保存公司信息
     * @param Company $company
     * @throws \Exception
     * @return number
     */
    public function saveCompany(Company $company)
    {
        $data = array(
            'company_name' => $company->company_name,
            'tel' => $company->tel,
            'fax' => $company->fax,
            'contacts' => $company->contacts,
            'vocation' => $company->vocation,
            'mobile' => $company->mobile,
            'email' => $company->email,
            'province' => $company->province,
            'city' => $company->city,
            'area' => $company->area,
            'address' => $company->address,
            'url' => $company->url,
            'introduce' => $company->introduce,
        );
        if (!empty($company->logo)){
            $data = array_merge_recursive($data, array('logo'=>$company->logo));
        }
        $id = (int)$company->id;
        if ($id == 0){
            return $this->tableGateway->insert($data);
        }else{
            if ($this->getCompany($id)){
                return $this->tableGateway->update($data, array('id'=>$id));
            }else{
                throw new \Exception("Form id does not exist");
            }
        }
    }
    
    /**
     * 通过id删除公司信息
     * @param number $id
     * @return number
     */
    public function deleteCompany($id)
    {
        return $this->tableGateway->delete(array("id"=>$id));
    }
    
}