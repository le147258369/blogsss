<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class BaseController extends CI_Controller{
    public function __construct(){
        parent::__construct();
        //url 辅助函数
        $this->load->helper('url');
    }


    /**
     * @param $url
     * 重定向至输入的utl
     * 即跳转到指定页面
     */
    public function go($url){
        //var_dump($url);
       echo "<script>window.location.href='http://".base_url().$url."'</script>";
    }

    /**
     * 获取当前页面uri路径
     * @return string
     */
    public function currUri(){
       return uri_string();
    }
}