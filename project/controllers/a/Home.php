<?php
defined('CTRLPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/AdminController.php');
class Home extends AdminController{
    private $_outData = [
        'breadcrumb' => '',//面包屑
    ];

    public function index(){
        //输出面包屑数据-------------------------------//
        $breadcrumb = [
            ['name' => '登陆信息'],
        ];
        $breadcrumb = $this->addBreadcrumb($breadcrumb);
        $this->_outData['breadcrumb'] = $breadcrumb;
        //-------------------------------输出面包屑数据//
        //输出页面数据---------------------------------//
        $logedInfo = [
            ['title' => '登陆人','value' => $this->logged['accName']],
            ['title' => '上次登陆时间','value' => $this->logged['lastLoginTime']],
            ['title' => '上次登陆IP地址','value' => $this->logged['lastLoginIp']]
        ];
        $this->_outData['logInfo'] = $logedInfo;
        //---------------------------------输出页面数据//
        //输出页面结果---------------------------------//
        $this->initTpl('home.html',$this->_outData);

    }
}