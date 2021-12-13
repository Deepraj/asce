<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class MultiLicenses extends CI_Controller {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
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
		$this->load->model ( 'MultiLicenseModel');
		$this->load->library ('session');
		$this->load->library('form_validation');
		
		/*if(empty($this->session->userdata("MasterCustomermainId"))){
            redirect(site_url(),'refresh');
		 }*/
		
	}
	public function index(){
	if($this->input->post('submit')){ 
	 $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
	 $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[3]|max_length[20]|alpha');
	 $this->form_validation->set_rules('middle_name', 'Middle Name', 'trim|required|min_length[3]|max_length[20]|alpha');
	 $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[3]|max_length[20]|alpha');
	// print_r($_POST); die;
	$id=$this->input->post('id');
	 $data= array(
       'email' => $this->input->post('email'),
	   'first_name' => $this->input->post('first_name'),
	   'middle_name' => $this->input->post('middle_name'),
	   'last_name' => $this->input->post('last_name')
     );
	 
	 $update=$this->MuserModel->updateSubUser($id,$data);
	}
	 $master_id=$this->session->userdata('çarporationmasterid');
	 
	 $data['SubUserList']=$this->MultiLicenseModel->get_AllSubscriptions($master_id);
	//echo"<pre>"; print_r($data); die;
	 $this->load->view('pagetemplate/header-inner', $data); 
	 $this->load->view('MultiLicenses',$data);
	 
	}

	function deleteSubUser(){
		//echo "hello" die;
	 $id=$this->uri->segment('3');
	 $delete=$this->MuserModel->deleteSubUser($id);
	 $this->session->set_flashdata('message', 'You have deleted successfully.');
	 redirect('MuserAdmin', 'refresh');
	}
	function EditSubUser(){
	$id=$_GET['id'];
 	$data['getSubUser']=$this->MuserModel->EditSubUser($id);
	//print_r($data['getSubUser']); die;
	$this->load->view('pagetemplate/header',$data);
	$this->load->view('ManageSubUser_form',$data);
	}
	
	function SortbyProduct(){
	 $master_id=$this->session->userdata('MasterCustomermainId');
	 $sortBy = $this->input->get('sortby');
	 $productId=$this->input->post('productId');
	 $productName=$this->input->post('productName');
	 $data['SubUserList']=$this->MultiLicenseModel->fetchdata($productId,$productName,$sortBy,$master_id);
	 //echo "<pre>";print_r($data); die;
	 $this->load->view('pagetemplate/header-inner',$data); 
	 $this->load->view('MultiLicenses',$data);
	
   }	
}
