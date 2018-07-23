<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (CTRLPATH.'ext/BaseController.php');
class FrontendController extends BaseController{


	public function __construct(){
	    parent::__construct();
    }

    public function initTpl($html){
        $this->load->view("Main.html");
        $this->load->view("Header.html");
        $this->load->view($html);
        $this->load->view("Footer.html");
    }
}