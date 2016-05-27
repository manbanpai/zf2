<?php
namespace Ca\File;

use Zend\Filter\File\RenameUpload;

class File
{
    const SAVE_PATH = './data/uploads/';
    
    public function getSavePath()
    {
        return self::SAVE_PATH.date('Y-m', time())."/";
    }
    
    public function filter($value)
    {
        $savepath = $this->getSavePath();
        if (!file_exists($savepath)){
            mkdir($savepath, 0777, true);
        }
        $filter = new RenameUpload(array(
            'target' => $savepath."file",
            'use_upload_extension' => true,
            'randomize' => true,
        ));
        return $filter->filter($value);
    }
}