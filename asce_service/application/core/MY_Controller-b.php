<?php
//require_once SYSDIR . '/libraries/Session/Session.php';
class MY_Controller extends CI_Controller  {
function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		 $this->load->helper('form');
		$this->load->library('session');
		  //print_r($_SESSION);die;
		  if(empty($this->session->userdata("user_id"))){
		    $this->session->set_flashdata('message_name', 'Session has been Expired!');
		   //secho "asdasd";die;
		     //$this->load->view('login_form');
              redirect(site_url('auth/login'));
	}else{
	
		
	}
}
}
?>