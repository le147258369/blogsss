<?php
defined('CTRLPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/BaseController.php');
class AdminController extends BaseController{

    protected $isLogin = false;//登陆状态
    protected $logged = [];//登陆信息
    private $_exceptionPath = 'a/login';//例外路径
    private $_addCssOrJs = '';//输出JS或CSS 文件
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
    public function initTpl($html,$data= array()){
        //输出页面模板
        $outTpl = [];
        $outTpl['Header'] = $this->load->view('/a/Header.html','',TRUE);
        $outTpl['Left'] = $this->load->view('/a/Left.html','',TRUE);
        $outTpl['Content'] = $this->load->view('/a/'.$html,$data,TRUE);
        $outTpl['addNeedStyFile'] = $this->_addCssOrJs;
        $this->parser->parse('/a/Main.html',$outTpl);
    }
    /**
     * 页面添加css/js方法
     * @param $type
     * @param $url
     */
    public function addNeedStyFile($type,$url){
        if($type == 'js'){//输出JS文件
            $this->_addCssOrJs .= '<script src="/js'.$url.'"></script>';
        }
        if($type == 'css'){//输出CSS文件
            $this->_addCssOrJs .= '<link rel="stylesheet" href="/css'.$url.'" type="text/css"/>';
        }
    }

    public function addBreadcrumb($data = array()){
        $breadcrumb = '<ul class="breadcrumb no-border no-radius b-b b-light pull-in">';
        $breadcrumb .= ' <li><a href="/a"><i class="fa fa-home"></i>后台首页</a></li>';
        //
        if(!empty($data)){
            foreach($data as $row){
                if(isset($row['url']) && !empty($row['url'])){
                    $breadcrumb .= '<li class="active"><a href="'.$row['url'].'">'.$row['name'].'</a></li>';
                }else{
                    $breadcrumb .= '<li class="active">'.$row['name'].'</li>';
                }
            }
        }
        $breadcrumb .= '</ul>';
        return $breadcrumb;
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
                $this->logged = $this->llogin->info;
            }
        }
    }
}