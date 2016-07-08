<?php
namespace Member\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
class MemberCompanyTable extends AbstractTableGateway
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
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
     * 保存会员公司信息
     * @param Company $company
     * @throws \Exception
     * @return number
     */
    public function saveCompany(MemberCompany $company)
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
     * 通过id删除会员公司信息
     * @param number $id
     * @return number
     */
    public function deleteCompany($id)
    {
        return $this->tableGateway->delete(array("id"=>$id));
    }
    
    /**
     * 分页
     * @param number $page
     * @param number $itemsPerPage
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator($page=1, $itemsPerPage=10)
    {
        $select = new Select('lic_member_company');
        $select->order('id desc');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new MemberCompany());
        $adapter = new DbSelect($select, $this->tableGateway->getAdapter(), $resultSetPrototype);
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($itemsPerPage);
        return $paginator;
    }
}