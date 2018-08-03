<?php
defined('CTRLPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/AdminController.php');
class Profile extends AdminController{
    /**
     * 修改密码
     */
    public function editpwd(){
        print_r($_POST);die;
    }
}