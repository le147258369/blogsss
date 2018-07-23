<?php
defined('CTRLPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/AdminController.php');
class Login extends AdminController{
    /**
     * 输出登陆页面
     */
    public function index(){
        //输出js请求验证token
        $outputData = [
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_value' => $this->security->get_csrf_hash(),
        ];
        $this->parser->parse('/a/login.html',$outputData);
    }

    /**
     * 执行登陆
     */
    public function doLogin(){
        //检查必要栏位是否填写
        if(!isset($_POST) || empty($_POST) || !isset($_POST['username']) || empty($_POST['username']) ||
            !isset($_POST['password']) || empty($_POST['password']) || !isset($_POST['code']) || empty($_POST['code'])){
            $this->outputJSON(array('code' => 1,'msg'=>'帐号、密码或验证码未填写！'));exit;
        }
        //检查验证码是否正确
        if($_SESSION['captcha'] != strtoupper($_POST['code'])){
            $this->outputJSON(array('code' => 2,'msg'=>'验证码输入错误！'));exit;
        }
        //验证帐号密码是否匹配
        $this->load->model('account_model');
        $rs = $this->account_model->verify($_POST['username'],$_POST['password']);
        if(empty($rs)){
            $this->outputJSON(array('code' => 3,'msg' => '帐号或密码输入错误！'));exit;
        }
        //检查帐号是否启用
        if($rs['acc_enable'] == 'N'){
            $this->outputJSON(array('code' => 4,'msg' => '帐号未启用，请联系管理员！'));exit;
        }
        //检查帐号是否被假删除
        if($rs['acc_delete'] == 'Y'){
            $this->outputJSON(array('code' => 5,'msg' => '帐号已被删除，请联系管理员！'));exit;
        }
        //帐号、密码、验证码正确。执行登陆操作
        $this->load->library('LLogin');
        $result = $this->llogin->login($rs);
        if($result){
            //修改最后登陆时间和IP地址
            $editData = [
                'acc_login_tiem' => time(),
                'acc_login_ip' => $_SERVER['REMOTE_ADDR']
            ];
            $this->account_model->edit($rs['acc_id'],$editData);
        }
        //登陆成功，跳转至后台首页
        $this->outputJSON(array('code' => 0,'msg' => '/a'));exit;
    }

    /**
     * 退出登陆
     */
    public function loginOut(){
        $this->load->library('LLogin');
        $this->llogin->loginOut();
        $this->go('a/login');
    }
    /**
     * 输出验证码
     */
    public function code(){
        $this->load->library('LCode');
        $this->lcode->getCode();
    }
/*//新增帐号
//产生token---------------------------------------------------------------------//
$tokenTime = time();
$token = password_hash($tokenTime.$_POST['password'],PASSWORD_DEFAULT);
//---------------------------------------------------------------------产生token//
$data = [
    'acc_username' => $_POST['username'],
    'acc_password' => $_POST['password'],
    'acc_delete' => 'N',
    'acc_enable' => 'Y',
    'acc_lastedit_time' => time(),
    'acc_token' => $token,
];
$this->load->model('account_model');
$RS = $this->account_model->add($data);
if($RS){
    $this->outputJSON(array('code' => 0,'msg' => '登陆成功！'));
}else{
    $this->outputJSON(array('code' => 2,'msg' => '登陆失败！'));
}
*/

}