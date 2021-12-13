<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class SendEmail extends  CI_Controller {
   function __construct(){
		// Construct the parent class
		parent::__construct ();
		$this->load->helper (array (
				'form',
				'url',
				'xml',
				'security',
				'directory' 
		) );
	  $this->load->library('email');
	}
 function index(){  
  $this->email->from('admin@yourdomainname.com', "Admin Team");
  $this->email->to("anujmn@gmail.com");
  //$this->email->cc("testcc@domainname.com");
  $this->email->subject("This is test subject line");
  $this->email->message("Mail sent test message...");
  $data['message'] = "Sorry Unable to send email..."; 
  if($this->email->send()){     
  // $data['message'] = "Mail sent...";   
   echo "mail send";
  }else{
   show_error($this->email->print_debugger());
  
  }   
  // forward to index page
  //$this->load->view('index', $data);  
  }
 }
?>
