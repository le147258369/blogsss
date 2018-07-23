<?php
class LCom{
    protected $_ci;  //CI资源物件

    public function __construct() {
        $this-> _ci = & get_instance();
    }

    /**
     * 將密碼不可逆加密
     * encryption_key 密钥
     * @param $passwd 密碼
     * @return string
     * example:
     * $this-> load -> library('LCom');
     *  $passwd = "12345";
     *  echo $this->lcom->encryptPasswd($passwd);
     */
    public function encryptPasswd($passwd){
        return md5(sha1($this -> _ci -> config -> item('encryption_key'). $passwd));
    }
}