<?php
namespace Member\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Select;
class LicenseTable extends AbstractTableGateway
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    /**
     * 获取license表记录
     * @param number $id
     * @throws \Exception
     * @return \Zend\Db\Sql\Select|Ambigous <multitype:, ArrayObject, NULL>
     */
    public function getLicense($id)
    {
        $id = (int) $id;
        $result = $this->tableGateway->select(function(Select $select) use($id){
            $select->join('lic_certficate', 'lic_certficate.id=lic_license.certficate_id',array('serial'),$select::JOIN_LEFT);
            $select->where(array("lic_license.id=$id"));
            return $select;
        });
        $row = $result->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    /**
     * 保存
     * @param License $license
     * @return boolean
     */
    public function saveLicense(License $license)
    {
        $data = array(
            'max_client_number' => $license->max_client_number,
            'soft_valid_days' => $license->soft_valid_days,
            'client_info' => $license->client_info,
            'server_domain' => $license->server_domain,
            'server_cpu_id' => $license->server_cpu_id,
            'server_ip' => $license->server_ip,
            'server_mac' => $license->server_mac,
            'license_savepath' => $license->license_savepath,
            'sha1file' => $license->sha1file,
            'status' => $license->status,
            'create_time' => $license->create_time,
            'serialnumber' => $license->serialnumber,
            'certficate_id' => $license->certficate_id,
            'membercompany_id' => $license->membercompany_id,
            'expire_time' => $license->expire_time,
            'audit' => $license->audit,
        );
        
        $id = (int)$license->id;
        if ($id == 0){
            return $this->tableGateway->insert($data);
        }
    }
    
    /**
     * 审核
     * @param int $id
     * @return number
     */
    public function audit($id)
    {
        $id = (int)$id;
        if ($id!=0){
            return $this->tableGateway->update(array('audit'=>'1'),array('id'=>$id));
        }
    }
    
    /**
     * 删除
     * @param number $id
     * @return number
     */
    public function deleteLicense($id)
    {
        return $this->tableGateway->delete(array('id'=>$id));
    }
    
    /**
     * 分页
     * @param number $page
     * @param number $itemsPerPage
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator($page=1, $itemsPerPage=10, $where='')
    {
        $select = new Select('lic_license');
        $select->join('lic_member_company', 'lic_license.membercompany_id=lic_member_company.id',array('company_name'));
        $select->order('id desc');
        if (!empty($where)){
            $select->where($where);
        }
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new License());
        $adapter = new DbSelect($select, $this->tableGateway->getAdapter(), $resultSetPrototype);
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($itemsPerPage);
        return $paginator;
    }
    
    /**
     * 获取序列号
     * @return number
     */
    public function getSerialNumber()
    {
        return time();
    }
}