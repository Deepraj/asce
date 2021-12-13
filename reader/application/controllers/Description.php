<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Description extends CI_Controller {

	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->helper(array('form', 'url','xml','security','directory'));
		$this->load->database();
	}
	public function index()
	{  
		$id=$_REQUEST['id'];
		//echo $id;die;
		//$id=$this->input->get('id', TRUE);
		$this->load->model('ProductDescriptionModel');
		$data['bookList'] = $this->ProductDescriptionModel->getAllBooks($id);
		//echo '<pre>';print_r($data); die;
		$this->load->view('ProductDescription',$data);
	}
	
}
