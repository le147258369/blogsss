<?php
defined('CTRLPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/AdminController.php');
class Login extends AdminController{
    /**
     * 输出登陆页面
     */
    public function index(){
        $outputData = [
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_value' => $this->security->get_csrf_hash(),
        ];
        $this->parser->parse('/a/login.html',$outputData);
    }

    public function doLogin(){
        print_r($_POST);
    }
    /**
     * 输出验证码
     */
    public function code(){
        $this->load->library('LCode');
        $this->lcode->getCode();
    }
}