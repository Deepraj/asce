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
 $this->load->library('email');
  // Email configuration
  $this->load->library('email');
  $this->email->from('admin@yourdomainname.com', "Admin Team");
  $this->email->to("anuj.dubey@adi-mps.com");
  //$this->email->cc("testcc@domainname.com");
  $this->email->subject("This is test subject line");
  $this->email->message("Mail sent test message...");
  $data['message'] = "Sorry Unable to send email..."; 
  if($this->email->send()){     
  // $data['message'] = "Mail sent...";   
   echo "mail send";
  }else{
   echo "mail not send";
  
  }   
  // forward to index page
  //$this->load->view('index', $data);  
 }
 }
?>
