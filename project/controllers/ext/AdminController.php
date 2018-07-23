<?php
defined('CTRLPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/BaseController.php');
class AdminController extends BaseController{

    private $isLogin = false;//登陆状态
    private $_loginInfo = [];//登陆信息
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

    /**
     * 初始化页面
     * @param $html
     * @param $data
     */
    public function initTpl($html,$data){
        $this->parser->parse('/a/'.$html,$data);
    }

    /**
     * 检查登陆状态未登陆跳转至登陆页面
     */
    private function _checkLogin(){
        if($this->isLogin == false){//未登陆状态
            //检查library登陆状态
            $this->load->library('LLogin');
            if($this->llogin->isLogged == false){//未登陆状态
                //跳转至登陆页面
                $uri = explode('/',$this->currUri());
                if(count($uri) == 1) $uri[1] = 'home';
                if($uri[0].'/'.$uri[1] != $this->_exceptionPath){
                    $this->go($this->_exceptionPath);
                }
            }else{//已登陆状态
                $this->isLogin = true;
                $this->_loginInfo = $this->llogin->info;
            }
        }
    }
}