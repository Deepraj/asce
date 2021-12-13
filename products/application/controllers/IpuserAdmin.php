<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class IpuserAdmin extends CI_Controller {
	
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
		$this->load->model ( 'IpuserModel' );
		$this->load->library ('session');
		$this->load->library('form_validation');
		if(empty($this->session->userdata("MasterCustomermainId"))){
            redirect(site_url(),'refresh');
		 }
		
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
	 
	 $update=$this->IpuserModel->updateSubUser($id,$data);
	}
	 $master_id=$this->session->userdata('çarporationmasterid');
	// print_r($master_id); die;
	 $data['SubUserList']=$this->IpuserModel->SubUserlist($master_id);
	// echo "<pre>"; print_r($data); die;
	 $this->load->view('pagetemplate/header-inner', $data); 
	 $this->load->view('Ipuser',$data);
	 
	}

	function deleteSubUser(){
	 $id=$this->uri->segment('3');
	 $delete=$this->IpuserModel->deleteSubUser($id);
	 $this->session->set_flashdata('message', 'You have deleted successfully.');
	 redirect('IpuserAdmin', 'refresh');
	}
	function EditSubUser(){
	$id=$_GET['id'];
 	$data['getSubUser']=$this->IpuserModel->EditSubUser($id);
	//print_r($data['getSubUser']); die;
	$this->load->view('pagetemplate/header',$data);
	$this->load->view('ManageSubUser_form',$data);
	}
	function SortbyUser(){
	 $master_id=$this->session->userdata('MasterCustomermainId');
	 $sortBy = $this->input->get('sortby');
	 $email=$this->input->post('email');
	 $first_name=$this->input->post('first_name');
	 $data['SubUserList']=$this->IpuserModel->fetchdata($email,$first_name,$sortBy,$master_id);
	 $this->load->view('pagetemplate/header',$data); 
	 $this->load->view('Muser',$data);
	}	
}
