<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
class userPage extends MY_Controller  {
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
		$this->load->model('User_model');
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
    //Function for getting All Admin Status
    function getAllStatus()
    {
    	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
    	{
    		$this->session->set_userdata('last_url',$this->uri->segment(1));
    		redirect('auth/', 'refresh');
    	}else{
    		$this->load->model('User_model');
    		$var =  $this->User_model->list_Status();
    		return $var ;
    	}
    }
    //Function for getting All Products
    function getProducts()
    {
    	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
    	{
    		$this->session->set_userdata('last_url',$this->uri->segment(1));
    		redirect('auth/', 'refresh');
    	}else{
    		$this->load->model('User_model');
    		$var =  $this->User_model->list_AllProducts();
    		return $var ;
    	}
    }
    //Function for getting All Currency
    function getCurrency()
    {
    	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
    	{
    		$this->session->set_userdata('last_url',$this->uri->segment(1));
    		redirect('auth/', 'refresh');
    	}else{
    		$this->load->model('User_model');
    		$var =  $this->User_model->list_AllCurrency();
    		return $var ;
    	}
    }
    //Function for getting All IP Versions
    function getAllIpVersion()
    {
    	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
    	{
    		$this->session->set_userdata('last_url',$this->uri->segment(1));
    		redirect('auth/', 'refresh');
    	}else{
    		$this->load->model('User_model');
    		$var =  $this->User_model->list_AllIpVersions();
    		return $var ;
    	}
    }
    //Function for getting All Countries Names
    function getAllCountry()
    {
    	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
    	{
    		$this->session->set_userdata('last_url',$this->uri->segment(1));
    		redirect('auth/', 'refresh');
    	}else{
    		$this->load->model('User_model');
    		$var =  $this->User_model->list_AllCountries();
    		return $var ;
    	}
    }
	// fnction to add a user
    public function User($id = 0)
    {
		if (!$this->tank_auth->is_logged_in(TRUE) && $this->tank_auth->is_user_admin(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			
			//$data['prodList']=$this->User_model->list_AllProducts();
			$data['userInfo'] = $this->userinfo(); 
			if($id==0){
			$this->load->pagetemplate('addUser',$data);
			}
			
		}
		
		
		 if($id > 0){
			$this->load->model('User_model');
			$User_data = $this->User_model->get_User($id);
			$master_id=$User_data[0]->m_masterid;
			$data['id']=$id;
			$data['masterid']=$User_data[0]->m_masterid;
			$data['sub_id']=$User_data[0]->m_subcustid;
			$data['cust_type']=$User_data[0]->m_custtype;
			$data['m_licence_type']=$User_data[0]->m_licence_type;
			$data['lablename']=$User_data[0]->m_lablename;
			$data['firstname']=$User_data[0]->m_firstname;
			$data['lastname']=$User_data[0]->m_lastname;
			$data['primarymail']=$User_data[0]->m_primaryemail;
			$data['onlinemale']=$User_data[0]->m_onlineemail;
			$data['adminstatus']=$User_data[0]->line_status;
			$orderId=$User_data[0]->order_id;
            $data['Ipid']= $this->User_model->get_Corporation($orderId);	
                     $data['Ipids']  = $data['Ipid'][0]->id	;		
			//echo '<pre>'; print_r($data['Ipid'][0]->id); die;
			$data['subscriptions']=$this->User_model->get_AllSubscriptionsIndivisual($master_id);
			$this->load->pagetemplate('addUser',$data);
		}
    }    
	###############Function for view Institutes
	public function listUser($id='')
	{
		$sortBy = $this->input->get('sortby');
		if (!$this->tank_auth->is_logged_in_admin(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			 redirect('auth/', 'refresh');
		}else{
			if($id==1){
			$searchName =   trim($this->input->post('userNameSearch'));
			$searchEmail =  trim($this->input->post('userEmailSearch'));
			$searchStatus = trim($this->input->post('userStatus'));
			$data['users'] = $this->User_model->list_Individual_Users();
			//print_r($data['users']); die;
			$data['userNameSearchValue']=$searchName;
			$data['userEmailSearchValue']=$searchEmail;
			$data['userStatusValue']=$searchStatus;
			$data['userInfo'] = $this->userinfo();
			$this->load->pagetemplate('listUser',$data);
			}else if($id==2){
			$searchName = trim($this->input->post('userNameSearch'));
			$searchEmail = trim($this->input->post('userEmailSearch'));
			$searchStatus = trim($this->input->post('userStatus'));
			$data['users'] = $this->User_model->list_Institutional_Users();
			//print_r($data['users']); die;
			$data['userNameSearchValue']=$searchName;
			$data['userEmailSearchValue']=$searchEmail;
			$data['userStatusValue']=$searchStatus;
			$data['userInfo'] = $this->userinfo();
			$this->load->pagetemplate('listUser',$data);
			}else if($id==3){
			$searchName = trim($this->input->post('userNameSearch'));
			$searchEmail = trim($this->input->post('userEmailSearch'));
			$searchStatus = trim($this->input->post('userStatus'));
			$data['users'] = $this->User_model->list_All_Users();
			//print_r($data['users']); die;
			$data['userNameSearchValue']=$searchName;
			$data['userEmailSearchValue']=$searchEmail;
			$data['userStatusValue']=$searchStatus;
			$data['userInfo'] = $this->userinfo();
			$this->load->pagetemplate('listUser',$data);
			}
			
			else{
			$this->load->model('User_model');
			$searchName = $this->input->post('userNameSearch');
			$searchEmail = $this->input->post('userEmailSearch');
			$searchStatus = $this->input->post('userStatus');
			$name = explode(" ",$searchStatus); 
            $fname=	$name[0];
            $lname=$name[1];
			$data['users'] = $this->User_model->list_Users($this->userid,$searchName,$searchEmail,$searchStatus,$sortBy,$fname,$lname);
			//print_r($data['users']); die;
			$data['userNameSearchValue']=$searchName;
			$data['userEmailSearchValue']=$searchEmail;
			$data['userStatusValue']=$searchStatus;
			$data['userInfo'] = $this->userinfo();
			$this->load->pagetemplate('listUser',$data);
			}
		}
	}
	############function for deleting the institute
	public function deleteUser($userId){
		$this->load->model('User_model');
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
		$data['institutes'] = $this->User_model->deleteUser($userId);
		$this->session->set_userdata('last_url','');
		$data['userInfo'] = $this->userinfo();
		$this->session->set_flashdata('msg', 'User Deleted Successfully....');
		redirect('userPage/listUser', 'refresh');
		}
	}		
}
