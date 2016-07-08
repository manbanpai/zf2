<?php
namespace License\Model;

class MacAddr
{
    public $return_array = array();
    public $mac_addr;
    
    /**
     * 获取mac地址
     * @param string $os_type
     */
    public function getMacAddr($os_type)
    {
        switch (strtolower($os_type)){
            case "linux":
                $this->forLinux();
                break;
            default:
                $this->forWindows();
                break;
        }
        $temp_array = array();
        foreach ( $this->return_array as $value ){
            if (preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i",$value,$temp_array)){
                $this->mac_addr = $temp_array[0];
                break;
            }
        }
        unset($temp_array);
        return $this->mac_addr;
    }
    
    /**
     * 获取windows系统的mac地址
     * @return multitype:
     */
    public function forWindows(){
        @exec("ipconfig /all", $this->return_array);
        if ($this->return_array)
            return $this->return_array;
        else{
            $ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe";
            if (is_file($ipconfig))
                @exec($ipconfig." /all", $this->return_array);
            else
                @exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $this->return_array);
            return $this->return_array;
        }
    }
    
    /**
     * 获取linux下mac地址
     * @return multitype:
     */
    public function forLinux(){
        @exec("ifconfig -a", $this->return_array);
        return $this->return_array;
    }
}