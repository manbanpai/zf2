<?php
namespace Ca\Cert;

/**
 * 
 * @param string $countryName
 * @param string $stateOrProvinceName
 * @param string $localityName
 * @param string $organizationName
 * @param string $organizationalUnitName
 * @param string $commonName
 * @param string $emailAddress
 * @param string $surname
 * 
 */
class X509 
{
     public $attr = array();
     
     public $x509;
     public $output;
     
     public function setDn($key, $value)
     {
         $this->attr[$key] = $value;
     }
     
     public function getDn()
     {
         return $this->attr;
     }
     
     public function export()
     {
         if (openssl_x509_export($this->x509, $this->output)){
             return $this->output;
         }else{
             return false;
         }
     }
     
     public function parse($cert, $shortnames = true)
     {
         return openssl_x509_parse($cert, $shortnames);
     }
     
     public function read($certdata)
     {
         return openssl_x509_read($certdata);
     }
}