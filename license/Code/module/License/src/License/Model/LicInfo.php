<?php
namespace License\Model;

use Zend\Http\PhpEnvironment\RemoteAddress;
class LicInfo
{    
    /**
     * 获取ip地址
     * @return string
     */
    public function getIp()
    {
        $remote = new RemoteAddress();
        return $remote->getIpAddress();
    }
    
    /**
     * 获取cpu id
     * @return string
     */
    public function getCpuId()
    {
        $cpuId = '';
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
            exec("wmic CPU get ProcessorID", $out, $status);
            if (isset($out[1])){
                $cpuId = $out[1];
            }
        }else{
            exec("dmidecode -t 4 | grep ID | sort -u", $out, $status);
            if (isset($out[0])){
                $cpuId = $out[0];
            }
        }
        return $cpuId;
    }
    
    /**
     * 获取mac地址
     * @return string
     */
    public function getMac()
    {
        $macaddr = new MacAddr();
        return $macaddr->getMacAddr(PHP_OS);
    }
}