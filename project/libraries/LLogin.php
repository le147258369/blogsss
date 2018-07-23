<?php
class LLogin{
    public $isLogged = false;//是否已登入
    public $info = [];//帐号信息
    public function __construct(){
        if(isset($_SESSION["info"]) && count($_SESSION["info"]) > 0){
            $this -> isLogged = true;
            $this -> info = $_SESSION["info"];
        }
    }

    /**
     * 执行登陆动作
     * @param $accInfo
     * @return bool
     */
    public function login($accInfo){
        //先执行退出操作
        $this->loginOut();
        //初始化登陆资料
        $_SESSION['info'] = [
            'accId' => $accInfo['acc_id'],//帐号ID
            'accName' => $accInfo['acc_name'],//帐号昵称
            'token' => $accInfo['acc_token'],//帐号Token
            'lastLoginTime' => (!empty($accInfo['acc_login_tiem']))?
                '---':date('Y-m-d H:i:s',$accInfo['acc_login_tiem']),//最后登陆时间
            'lastLoginIp' => (!empty($accInfo['acc_login_ip']))?'---':$accInfo['acc_login_ip'],//最后登陆IP
        ];
        //变更登陆状态
        $this->isLogged = true;
        $this->info = $_SESSION['info'];
        return true;
    }

    /**
     * 退出登陆
     */
    public function loginOut(){
        if(isset($_SESSION['info'])) unset($_SESSION['info']);
    }
}