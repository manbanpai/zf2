<?php
namespace Ca\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Select;
use Ca\Cert\X509;
class CertficateTable extends AbstractTableGateway
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    /**
     *  开启事务
     * @return \Zend\Db\Adapter\Driver\ConnectionInterface
     */
    public function beginTransaction()
    {
        return $this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
    }
    
    /**
     * 提交事务
     * @return \Zend\Db\Adapter\Driver\ConnectionInterface
     */
    public function commit()
    {
        return $this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();
    }
    
    /**
     * 回滚事务
     * @return \Zend\Db\Adapter\Driver\ConnectionInterface
     */
    public function rollback()
    {
        return $this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();
    }
    
    /**
     * 获取证书信息
     * @param number $id
     * @throws \Exception
     * @return Ambigous <multitype:, ArrayObject, NULL>
     */
    public function getCertficate($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id'=>$id));
        $row = $rowset->current();
        if(!$row){
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    /**
     * 存储证书信息
     * @param Certficate $certficate
     * @return int|boolean|number
     */
    public function saveCertficate(Certficate $certficate)
    {
        $data = array(
            'issuer_id' => $certficate->issuer_id,
            'user_country_name' => $certficate->user_country_name,
            'user_state_or_province_name' => $certficate->user_state_or_province_name, 
            'user_locality_name' => $certficate->user_locality_name,
            'user_organization_name' => $certficate->user_organization_name,
            'user_organizational_unit_name' => $certficate->user_organizational_unit_name,
            'user_common_name' => $certficate->user_common_name,
            'user_email_address' => $certficate->user_email_address,            
            'user_surname' => $certficate->user_surname,
            'serial' => $certficate->serial,
            'valid_days' => $certficate->valid_days,
            'ctype' => $certficate->ctype,
            'begin_time' => $certficate->begin_time,
            'end_time' => $certficate->end_time,
            'is_revoked' => $certficate->is_revoked,
            'cert_savepath' => $certficate->cert_savepath,
            'sha1file' => $certficate->sha1file,
            'createtime' => time(),
        );
        $id = (int)$certficate->id;
        if ($id == 0){
            if ($this->tableGateway->insert($data)){
                return $this->tableGateway->lastInsertValue;
            }else{
                return false;
            }
        }else{
            if ($this->getCertficate($id)){
                return $this->tableGateway->update($data, array('id'=>$id));
            }else{
                return false;
            }
        }
    }
    
    public function updateCertficate($data, $id)
    {
        return $this->tableGateway->update($data, array('id'=>$id));
    }
    
    /**
     * 分页
     * @param number $page
     * @param number $itemsPerPage
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator($page=1,$itemsPerPage=10)
    {
        $select = new Select('lic_certficate');
        $select->order('id desc');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Certficate());
        $adapter = new DbSelect($select, $this->tableGateway->getAdapter(), $resultSetPrototype);
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($itemsPerPage);
        return $paginator;        
    }
    
    /**
     * 证书序列号
     * @return number
     */
    public function getSerialNumber()
    {
        return time();
    }
    
    /**
     * 数字转16进制
     * @param number $num
     * @return string
     */
    public function serialNumberToHex($num)
    {
        $num = dechex($num);
        return '0x'.$num;
        $str = '0x';
        for ($i=0;$i<strlen($num);$i++){
            $str .= $num[$i];
            if ($i%2==1){
                $str .= ' ';
            }
        }
        return $str;
    }
    
    /**
     * 获取证书有效期时间
     * @param string $certFilePath
     * @return multitype:string
     */
    public function getCertDate($certFilePath)
    {
        $fp = fopen($certFilePath, 'r');
        $cert = fread($fp, filesize($certFilePath));
        fclose($fp);
    
        $x509 = new X509();
        $x509cert = $x509->read($cert);
        $c = $x509->parse($x509cert);
        
        return array(
            's' => date('Y-m-d H:i:s', $c['validFrom_time_t']),
            'e' => date('Y-m-d H:i:s', $c['validTo_time_t']),
        );
    }
    
}
