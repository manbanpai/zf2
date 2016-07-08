<?php
namespace Ca\Cert;

class Sign 
{
    public $csr;
    public $cacert;
    public $priv_key;
    public $numberofdays = 3650;
    public $serialnumber = 0;
        
    public $attr = array();
    
    public function setCsr($csr)
    {
        $this->csr = $csr;
    }
    
    public function getCsr()
    {
        return $this->csr;
    }
    
    public function setCaCert($cert)
    {
        $this->cacert = $cert;
    }
    
    public function getCaCert()
    {
        return $this->cacert;
    }
    
    public function setPrivKey($priv_key)
    {
        $this->priv_key = $priv_key;
    }
    
    public function getPrivKey()
    {
        return $this->priv_key;
    }
    
    public function setNumberOfDays($days)
    {
        $days = (int) $days;
        $this->numberofdays = $days;
    }
    
    public function getNumberOfDays()
    {
        return $this->numberofdays;
    }
    
    public function setSignConfig($key, $value)
    {
        $this->attr[$key] = $value;
    }
    
    public function getSignConfig()
    {
        return $this->attr;
    }
    
    public function setSerialNumber($serialnumber = 0)
    {
        $this->serialnumber = $serialnumber;
    }
    
    public function getSerialNumber()
    {
        return $this->serialnumber;
    }
    
    public function csrSign()
    {
        return openssl_csr_sign($this->getCsr(), $this->getCaCert(), $this->getPrivKey(), $this->getNumberOfDays(), $this->getSignConfig(), $this->getSerialNumber());
    }
}