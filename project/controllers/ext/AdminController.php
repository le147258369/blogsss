<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (__DIR__.'/BaseController.php');
class AdminController extends BaseController{

    public function __construct(){
        parent::__construct();
        session_start();
    }
    public function initTpl($html){
        $this->load->view('/a/'.$html);
    }
}