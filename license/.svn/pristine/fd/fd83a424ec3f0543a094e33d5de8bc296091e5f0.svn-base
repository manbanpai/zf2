<?php
namespace Ca\Cert;

/**
 * @param string $digest_alg default value 'OPENSSL_ALGO_SHA256'
 * @param string $private_key_bits default value '2048'
 * @param string $private_key_type default value 'OPENSSL_KEYTYPE_RSA'
 *
 */
class Key
{    
    public $attr = array();
    
    public function setConfig($key, $value)
    {
        $this->attr[$key] = $value;
    }
    
    public function getConfig()
    {
        return $this->attr;
    }
    
    public function keyPair()
    {
        return openssl_pkey_new($this->getConfig());
    }
    
}