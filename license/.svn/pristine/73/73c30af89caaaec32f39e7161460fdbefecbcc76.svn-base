<?php
namespace Ca\Cert;

class Pkcs
{
    
    public function export($priv_key)
    {
        if (openssl_pkey_export($priv_key, $out)){
            return $out;
        }else{
            return false;
        }
    }
    
    public function exportToFile($priv_key)
    {
        if(openssl_pkey_export_to_file($priv_key, $outfile)){
            return $outfile;
        }else{
            return false;
        }
    }
    
}