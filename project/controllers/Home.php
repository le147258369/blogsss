<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH."/ext/FrontendController.php");

class Home extends FrontendController{

    public function index(){
        $this->initTpl('home.html');
    }
}