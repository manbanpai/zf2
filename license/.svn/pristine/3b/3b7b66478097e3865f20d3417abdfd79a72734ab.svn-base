<?php
namespace Ca\Cert;

class Csr
{           
    public function csrPair(X509 $x509, $priv_key, Key $keypair)
    {
        return openssl_csr_new($x509->getDn(), $priv_key, $keypair->getConfig());
    }
}