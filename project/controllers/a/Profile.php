<?php
defined('CTRLPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/AdminController.php');
class Profile extends AdminController{
    /**
     * 修改密码
     */
    public function editpwd(){
        //验证栏位是否填写完整
        if(!isset($_POST['code']) || empty($_POST['code'])){
            $this->outputJSON(array('code' => 1,'msg' => '验证码未填写！'));exit;
        }
        if(!isset($_POST['oldPwd']) || empty($_POST['oldPwd'])){
            $this->outputJSON(array('code' => 2,'msg' => '旧密码未填写！'));exit;
        }
        if(!isset($_POST['newPwd']) || empty($_POST['newPwd'])){
            $this->outputJSON(array('code' => 3,'msg' => '新密码未填写！'));exit;
        }
        if(!isset($_POST['confirmPwd']) || empty($_POST['confirmPwd'])){
            $this->outputJSON(array('code' => 3,'msg' => '请再次输入新密码！'));exit;
        }
        //检查验证码是否正确
        if($_SESSION['captcha'] != strtoupper($_POST['code'])){
            $this->outputJSON(array('code' => 4,'msg'=>'验证码输入错误！'));exit;
        }
        //检查两次密码输入是否一致
        if($_POST['newPwd'] != $_POST['confirmPwd']){
            $this->outputJSON(array('code' => 5,'msg'=>'两次输入密码不一致！'));exit;
        }
        //检查旧密码输入是否正确
        $this->load->model('account_model');
        $rs = $this->account_model->verifyForedit($this->logged['token'],$_POST['oldPwd']);
        if(empty($rs)){
            $this->outputJSON(array('code' => 6,'msg'=>'旧密码输入错误！'));exit;
        }
        //查看新密码与旧密码是否相同
        if($_POST['oldPwd'] == $_POST['newPwd']){
            $this->outputJSON(array('code' => 7,'msg'=>'旧密码与新密码相同，无需修改！'));exit;
        }
        //验证通过，修改旧密码及token等相关信息
        $editData = array(
            'acc_password' =>  $_POST['newPwd'],
            'acc_lastedit_time' => time(),
            'acc_token' => password_hash(time().$rs['acc_username'].$_POST['newPwd'],PASSWORD_DEFAULT)
        );
        $result = $this->account_model->edit($this->logged['accId'],$editData);
        if($result){
            $this->outputJSON(array('code' => 0,'msg'=>'密码修改成功，请重新登录！'));exit;
        }else{
            $this->outputJSON(array('code' => 8,'msg'=>'系统错误，请稍后重试！'));exit;
        }
    }
}