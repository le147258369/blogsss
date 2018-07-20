<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (__DIR__.'/../ext/AdminController.php');
class Login extends AdminController{
    /**
     * 输出登陆页面
     */
    public function index(){
        $this->load->view('/a/login.html');
    }

    public function doLogin(){

    }
    /**
     * 输出验证码
     */
    public function code(){
        $this->load->library('LCode');
        $this->lcode->getCode();
    }
}