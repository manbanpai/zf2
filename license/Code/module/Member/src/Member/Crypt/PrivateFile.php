<?php
namespace Member\Crypt;

class PrivateFile
{
    /**
     * 文件扩展名
     * @var string
     */
    const FILE_EXT = '.pem';
    
    /**
     * 私钥前缀
     * @var string
     */
    const FILE_NAME_PREFIX = 'private_';
    
    /**
     * 文件存储路径
     * @var string
     */
    const FILE_PATH = 'data/ca/';
    
    private $filename;
    private $filepath;
    
    public function setFileName($serial)
    {
        $filename = self::FILE_NAME_PREFIX.sha1($serial).self::FILE_EXT;
        $this->filename = $filename;
    }
    
    public function getFileName()
    {
        return $this->filename;
    }
       
    /**
     * 获取私钥内容
     */
    public function getPemString()
    {
        $filename = self::FILE_PATH.$this->getFileName();
        if (file_exists($filename)){
            return file_get_contents($filename);
        }
    }    
    
}