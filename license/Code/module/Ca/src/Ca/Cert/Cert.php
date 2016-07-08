<?php
namespace Ca\Cert;

class Cert
{
    private $privateFile;
    private $caFile;
    private $days = 3650;
    private $serial = 0;
    private $dn = array();
    
    public function setPrivateFile($privfile)
    {
        $this->privateFile = $privfile;
    }
    
    public function getPrivateFile()
    {
        return $this->privateFile;
    }
    
    public function setCaFile($cafile)
    {
        $this->caFile = $cafile;
    }
    
    public function getCaFile()
    {
        return $this->caFile;
    }
    
    public function setDays($days)
    {
        if (is_int($days))
            $this->days = $days;
    }
    
    public function getDays()
    {
        return $this->days;
    }
    
    public function setSerialNumber($serial)
    {
        if (is_int($serial))
            $this->serial = $serial;
    }
    
    public function getSerialNumber()
    {
        return $this->serial;
    }
    
    public function setDn($dn)
    {
        if (is_array($dn))
            $this->dn = $dn;
    }
    
    public function getDn()
    {
        return $this->dn;
    }
    
    public function certificate()
    {
        $dn = $this->getDn();
        $x509 = new X509();
        $x509->setDn('countryName', $dn['user_country_name']);
        $x509->setDn('stateOrProvinceName', $dn['user_state_or_province_name']);
        $x509->setDn('localityName', $dn['user_locality_name']);
        $x509->setDn('organizationName', $dn['user_organization_name']);
        $x509->setDn('organizationalUnitName', $dn['user_organizational_unit_name']);
        $x509->setDn('commonName', $dn['user_common_name']);
        $x509->setDn('emailAddress', $dn['user_email_address']);
    
        $keypair = new Key();
        $keypair->setConfig('digest_alg', 'OPENSSL_ALGO_SHA256');
        $keypair->setConfig('private_key_bits', 2048);
        $keypair->setConfig('private_key_type', 'OPENSSL_KEYTYPE_RSA');
        if(!($priv_key = $keypair->keyPair())){
            return false;
        }
    
        $csrpair = new Csr();
        if(!($csr = $csrpair->csrPair($x509,$priv_key,$keypair))){
            return false;
        }
    
        $sign = new Sign();
        $sign->setCsr($csr);
        $sign->setPrivKey($priv_key);
        $sign->setNumberOfDays($this->getDays());
        $sign->setSignConfig('digest_alg', 'sha256');
        $sign->setSerialNumber($this->getSerialNumber());
        if(!($cert = $sign->csrSign())){
            return false;
        }
    
        $pkcs = new Pkcs();
        if(!($pkey = $pkcs->export($priv_key))){
            return false;
        }
    
        $x509->x509 = $cert;
        if(!($caout = $x509->export())){
            return false;
        }
        
        if (!($this->privateKeyStore($this->getPrivateFile(), $pkey))){
            return false;
        }
    
        if(!$this->certStore($this->getCaFile(), $caout)){
            return false;
        }
        
        return true;
    }
    
    public function certStore($path, $cert)
    {
        if (empty($path)){
            return false;
        }
        
        $fp = fopen($path, 'w');
        $fwrite = fwrite($fp, $cert);
        fclose($fp);
        return $fwrite;
    }
    
    public function publicKeyStore()
    {
        
    }
    
    public function privateKeyStore($path, $pkey)
    {
        if (empty($path)){
            return false;
        }
        
        $fp = fopen($path, 'w');
        $fwrite = fwrite($fp, $pkey);
        fclose($fp);
        return $fwrite;
    }
    
}