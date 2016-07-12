<?php
namespace Member\Mail;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
class Mail
{
    private $mailName = 'mail.pzdf.com';
    private $mailHost = 'mail.pzdf.com';
    private $mailUsername = 'servicepzdf@pzdf.com';
    private $mailPassword = '2016pzdf.com';
    
    public $from = 'servicepzdf@pzdf.com';
    public $to = 'servicepzdf@pzdf.com';
    public $data = 'license文件';
    public $subject = 'license文件';
    public $attachmentName = '';
    public $filetype = 'text/plain';
    
    /**
     * 设置邮箱服务器名称
     * @param string $mailName
     */
    public function setMailName($mailName)
    {
        $this->mailName = $mailName;
    }
    
    /**
     * 获取邮箱服务器名称
     * @return string
     */
    public function getMailName()
    {
        return $this->mailName;
    }
    
    /**
     * 设置邮箱服务器地址
     * @param string $mailHost
     */
    public function setMailHost($mailHost)
    {
        $this->mailHost = $mailHost;
    }
    
    /**
     * 获取邮箱服务器地址
     * @return string
     */
    public function getMailHost()
    {
        return $this->mailHost;
    }
    
    /**
     * 设置邮箱服务器用户名
     * @param string $mailUsername
     */
    public function setMailUsername($mailUsername)
    {
        $this->mailUsername = $mailUsername;
    }
    
    /**
     * 获取邮箱服务器名称
     * @return string
     */
    public function getMailUsername()
    {
        return $this->mailUsername;
    }
    
    /**
     * 设置邮箱服务器密码
     * @param string $mailPassword
     */
    public function setMailPassword($mailPassword)
    {
        $this->mailPassword = $mailPassword;
    }
    
    /**
     * 获取邮箱服务器密码
     * @return string
     */
    public function getMailPassword()
    {
        return $this->mailPassword;
    }
    
    /**
     * 设置邮件主题
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    /**
     * 获取邮件主题
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * 设置邮件内容
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    /**
     * 获取邮件内容
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * 设置发件人邮箱
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }
    
    /**
     * 获取发件人邮箱
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }
    
    /**
     * 设置收件人邮箱地址
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }    
    /**
     * 获取收件人邮箱地址
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }
    
    /**
     * 设置附件名称，目前仅支持单个附件
     * @param string $attachment
     */
    public function setAttachmentName($attachmentName)
    {
        $this->attachmentName = $attachmentName;
    }    
    /**
     * 获取附件名称，目前仅支持单个附件
     * @return string
     */
    public function getAttachmentName()
    {
        return $this->attachmentName;
    }
    
    /**
     * 设置附件文件类型
     * @param string $filetype
     */
    public function setFiletype($filetype)
    {
        $this->filetype = $filetype;
    }
    /**
     * 获取附件文件类型
     * @return string
     */
    public function getFiletype()
    {
        return $this->filetype;
    }
    
    public function sendmail()
    {
        $msg = new Message();
        $msg->setFrom($this->getFrom(), $this->getFrom())
        ->setTo($this->getTo(), $this->getTo())
        ->setSubject($this->getSubject());        
        $html = new MimePart($this->getSubject());        
        $html->type = "text/html";
        $html->charset = "utf-8";        
        //附件
        $mimeMessage = new MimeMessage();
        $messageAttachment = new MimePart($this->getData());
        $messageAttachment->type = $this->getFiletype();
        $messageAttachment->filename = $this->getAttachmentName();
        $messageAttachment->encoding = \Zend\Mime\Mime::ENCODING_BASE64;
        $messageAttachment->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;
        $mimeMessage->setParts(array(
            $html,
            $messageAttachment
        ));
        $msg->setBody($mimeMessage);
        
        $smtpOpt = new SmtpOptions(array(
            'name' => $this->getMailName(),
            'host' => $this->getMailHost(),
            'port' => 25,
            'connection_class' => 'login',
            'connection_config' => array(
                'username' => $this->getMailUsername(),
                'password' => $this->getMailPassword(),
            )
        ));
        $trans = new Smtp();
        $trans->setOptions($smtpOpt);
        $trans->send($msg);
    }
    
}