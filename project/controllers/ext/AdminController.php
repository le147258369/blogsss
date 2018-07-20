<?php
defined('CTRLPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/BaseController.php');
class AdminController extends BaseController{

    private $isLogin = false;//登陆状态
    private $_exceptionPath = 'a/login';//例外路径
    public function __construct(){
        parent::__construct();
        //判断是否开启session
        if(!isset($_SESSION)) session_start();
        //加载页面模板引擎
        $this->load->library('parser');
        //检查登陆
        $this->_checkLogin();
    }
    public function initTpl($html,$data){
        $this->parser->parse('/a/'.$html,$data);
    }

    /**
     * 检查登陆状态未登陆跳转至登陆页面
     */
    private function _checkLogin(){
        if($this->isLogin == false){
            $uri = explode('/',$this->currUri());
            if($uri[0].'/'.$uri[1] != $this->_exceptionPath){
                $this->go($this->_exceptionPath);
            }
        }
    }
}