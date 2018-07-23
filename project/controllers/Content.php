<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH."ext/FrontendController.php");
class Content extends FrontendController{

    public function index(){
        echo 'Content/index';
    }
}