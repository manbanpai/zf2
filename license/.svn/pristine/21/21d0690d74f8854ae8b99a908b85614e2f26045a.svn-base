<?php
namespace Ca\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;

class CertficateIssuerTable extends AbstractTableGateway
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getCertficateIssuer($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id'=>$id));
        $row = $rowset->current();
        if (!$row){
            return false;
        }
        return $row;
    }
    
    /**
     * 证书使用者ID
     * @return number
     */
    public function getCertficateIssuerId()
    {
        $count = $this->tableGateway->select()->count();
        if ($count>0){
            $select = $this->tableGateway->getSql()->select();
            $select->limit(1);
            $res = $this->tableGateway->selectWith($select);
            $res = $res->toArray();
            return $res[0]['id'];
        }
    }
    
    public function saveCertficateIssuer(CertficateIssuer $certficateIssuer)
    {
        $data = array(
            'issuer_country_name' => $certficateIssuer->issuer_country_name,
            'issuer_state_or_province_name' => $certficateIssuer->issuer_state_or_province_name,
            'issuer_locality_name' => $certficateIssuer->issuer_locality_name,
            'issuer_organization_name' => $certficateIssuer->issuer_organization_name,
            'issuer_organizational_unit_name' => $certficateIssuer->issuer_organizational_unit_name,
            'issuer_common_name' => $certficateIssuer->issuer_common_name,
            'issuer_email_address' => $certficateIssuer->issuer_email_address,            
            'issuer_surname' => $certficateIssuer->issuer_surname,
        );
        $id = (int) $certficateIssuer->id;
        if ($id == 0){
            return $this->tableGateway->insert($data);
        }else{
            if ($this->getCertficateIssuer($id)){
                return $this->tableGateway->update($data, array('id'=>$id));
            }else{
                throw new \Exception("Form id does not exist");
            }
        }
    }
    
    public function deleteCertficateIssuer($id)
    {
        return $this->tableGateway->delete(array("id"=>$id));
    }
}