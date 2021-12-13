<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class RoleManagement extends MY_Controller  {
	private $userid;
	private $chapter_id;
	private $Success_result;

    function __construct()
    {
		// Construct the parent class
		parent::__construct();
		
		$this->load->helper(array('form', 'url','xml','security','directory'));
		$this->load->library(array('form_validation', 'tank_auth','xml','session','unzip'));
		$this->lang->load('tank_auth');
		$this->load->model('Xmlload_model');
		$this->load->model('Institute_model');
		$this->parse_data = array();
		$this->masterId = array();
		$this->load->database();
		$this->userid = $this->session->userdata('user_id');
		$this->cus_book_id = $this->session->userdata('cus_book_id');
		
		if(!$this->tank_auth->is_user_admin()){
		 $data['content'] = 'error_404'; // View name 
        $this->load->view('Book_library',$data);//loading in my template 
		//echo "No rights to view Book Library";
		//$this->load->view('book_library_error');
		//redirect('Custombook_library/show_custombook', 'refresh');
		exit;
		}
    }
   
    public function index()
    {
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
	        $this->list_book();
		}
    }    
	
	// Get the user details
   	function userinfo()
    {
       if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
       else
       {
        $this->load->model('Book_m');
        $data = $this->Book_m->userinfo_get($this->userid);
		return $data[0];
       }
    }
    ####################### Function For getting All Roles
    function getAllRoles()
    {
    	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
    	{
    		$this->session->set_userdata('last_url',$this->uri->segment(1));
    		redirect('auth/', 'refresh');
    	}else{
    		$this->load->model('role_Model');
    		$var =  $this->role_Model->listAllRoles();
    		return $var ;
    	}
    }
   ####################### Function For getting All Accessible Modules
    function getAllRoleModules()
    {
    	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
    	{
    		$this->session->set_userdata('last_url',$this->uri->segment(1));
    		redirect('auth/', 'refresh');
    	}else{
    		$this->load->model('role_Model');
    		$var =  $this->role_Model->listAllRoleModules();
    		return $var ;
    	}
    }
   #################### Function For Getting Role Permission For The User & Module
   function getAllRollPermissions($roleId)
   {
   	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
   	{
   		$this->session->set_userdata('last_url',$this->uri->segment(1));
   		redirect('auth/', 'refresh');
   	}else{
   		$this->load->model('role_Model');
   		$var =  $this->role_Model->listRolePermission($roleId);
   		return $var ;
   	}
   }
   ###############Function for view Institutes
	public function userPermission()
	{
		$sortBy = $this->input->get('sortby');
		$id=$this->uri->segment(3);
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			if($id<1){
			$this->load->model('Role_model');
			$searchRole = $this->input->post('roleName');
			$data['roles'] = $this->getAllRoles();
			$data['roleModules'] = $this->getAllRoleModules();
			$data['id']=$id;
			$this->session->set_userdata('last_url','');
			$data['userInfo'] = $this->userinfo();
			$this->load->pagetemplate('permission_list',$data);
			}
			else {
				$this->load->model('Role_model');
				$searchRole = $this->input->post('roleName');
				$data['roles'] = $this->getAllRoles();
				$data['roleModules'] = $this->getAllRoleModules();
				$data['permittedRoles'] = $this->getAllRollPermissions($id);
				$data['id']=$id;
				$this->session->set_userdata('last_url','');
				$data['userInfo'] = $this->userinfo();
				$this->load->pagetemplate('permission_list',$data);
			}
		}
		$post_value=$this->input->post('SavePrivilages');
		if($id>0 && $post_value=='Save')
		{
			$this->load->model('Role_model');
			$preveledges=$this->input->post('privilege');
			$updateRole=$this->role_Model->updateUserRole($preveledges,$id);
			redirect('RoleManagement/userPermission/'.$id, 'refresh');
		}
		
	}
	############function for deleting the institute
	public function deleteInstitute($instituteId){
		//echo $instituteId;
		//exit;
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
		$data['institutes'] = $this->Institute_model->deleteInstitute($instituteId);
		$this->session->set_userdata('last_url','');
		$data['userInfo'] = $this->userinfo();
		redirect('institutePage/InstituteList', 'refresh');
		}
	}		
		
}
