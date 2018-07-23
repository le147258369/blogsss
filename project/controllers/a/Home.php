<?php
defined('CTRLPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/AdminController.php');
class Home extends AdminController{

    public function index(){
        $this->initTpl('home.html');
    }
}