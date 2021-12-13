<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class DemoDescription extends CI_Controller {
	function __construct() {
		// Construct the parent class
		parent::__construct ();
		$this->load->helper (array (
				'form',
				'url',
				'xml',
				'security',
				'directory' 
		));
		$this->load->database ();
		$this->load->model ( 'ProductDescriptionModel' );
		$this->load->library ( 'session' );
		$this->load->library ( 'Encryption' );
	}
	
	public function index() {
		//echo"dsds"; die;
		$data = array();
		$GUID = $this->session->userdata( 'GUID' );
		$master_id = $this->session->userdata ('MasterCustomerId');
                $bookmasterid = $this->session->userdata ('bookmasterid');
  if(!empty($bookmasterid ))
  {
    $master_id =$bookmasterid ;
  }
		$id = $this->input->get ('id');
$isbn = $this->input->get ('isbn');
		$data ['books'] = $this->ProductDescriptionModel->getDemoBookInfo ($id);
		$data['subscriptions']=$this->ProductDescriptionModel->get_AllSubscriptions($master_id);
$data['subscriptions'][0]['isbn']=$isbn;
//	echo  "<pre>"; print_r($data); die;
		$this->load->view ( 'pagetemplate/header', $data );
		$this->load->view ( 'DemoProductDescription', $data );
		$this->load->view ( 'pagetemplate/footer', 'ProductList' );
	}
	
	
}
