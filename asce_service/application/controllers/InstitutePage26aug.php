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
class institutePage extends CI_Controller  {
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
	//Function for getting All Admin Titles
	function getAdminTitles()
	{
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_Titles();
			return $var ;
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
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_Status();
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
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_AllProducts();
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
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_AllCurrency();
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
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_AllIpVersions();
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
			$this->load->model('Institute_model');
			$var =  $this->Institute_model->list_AllCountries();
			return $var ;
		}
	}
	// fnction to add a book
    public function addInstitute($id = 0)
    {
		if (!$this->tank_auth->is_logged_in(TRUE) && $this->tank_auth->is_user_admin(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
		
			$data['userInfo'] = $this->userinfo();
			$data['insIpVersion'] = array(
					'name'	=> 'insIpVersion1',
					'id'	=> 'insIpVersion1',
					'value'	=> $this->getAllIpVersion(),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "IP Version",
					'class' => "form-control col-sm-3",
					'selected' => ''
			);
			$data['insMinIp']=array(
					'name'=>'insMinIp1',
					'id'=>'insMinIp1',
					'value'=>set_value('insMinIp'),
					'for'=>'Minimum IP Address',
					'class'=>'form-control',
					'onBlur'=>'checkIPStatus(id)',
			);
			$data['insMaxIp']=array(
					'name'=>'insMaxIp1',
					'id'=>'insMaxIp1',
					'value'=>set_value('insMaxIp'),
					'for'=>'Maximum IP Address',
					'class'=>'form-control',
					'onBlur'=>'checkIPStatus(id)'
			);
			$data['ipStatus'] = array(
					'name'	=> 'ipStatus1',
					'id'	=> 'ipStatus1',
					'value'	=> $this->getAllStatus(),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "IP Status",
					'class' => "form-control col-sm-3",
					'selected' => ''
			);
			$data['insemail'] = array(
					'name'	=> 'insEmail1',
					'id'	=> 'insEmail1',
					'value'	=> set_value('insEmail1'),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "Institute Email",
					'class' => "form-control"
			);
			$data['insFirstName'] = array(
					'name'	=> 'insFirstName1',
					'id'	=> 'insFirstName1',
					'value'	=> set_value('insFirstName1'),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "First Name",
					'class' => "form-control"
			);
			$data['insMiddleName'] = array(
					'name'	=> 'insMiddleName1',
					'id'	=> 'insMiddleName1',
					'value'	=> set_value('insMiddleName1'),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "Middle Name",
					'class' => "form-control"
			);
			$data['insLastName'] = array(
					'name'	=> 'insLastName1',
					'id'	=> 'insLastName1',
					'value'	=> set_value('insLastName1'),
					'maxlength'	=> 200,
					'size'	=> 30,
					'for' => "Last Name",
					'class' => "form-control",
			);
			
			if ($this->input->post('addInstituteIPAddressnext') && $id >0){
				
				$masterdetail=$this->Institute_model->getMasterID($id);
				$masterDet=$masterdetail[0]->m_masterid;
				$delIP_id=$this->Institute_model->deleteInstituteIP($masterDet);
				$ipBased=$this->input->post('ipBased');
				$referralUrl=$this->input->post('referralUrl');
				$accessToken=$this->input->post('accessToken');
				//$updatedIPValue=$this->Institute_model->updateAccessStatues($ipBased,$referralUrl,$accessToken,$id);
			    $no_of_ips=$this->input->post('no_of_ips');
				for($i=1;$i<=$no_of_ips;$i++){
					$institution_id=$this->input->post('institution_id');
					$ip_version=$this->input->post('insIpVersion'.$i);
					$low_ip=$this->input->post('insMinIp'.$i);
					$high_ip=$this->input->post('insMaxIp'.$i);
					$aui_status=$this->input->post('ipStatus'.$i);
					if(!empty($ip_version) && !empty($low_ip) && !empty($high_ip)){
		        $this->Institute_model->add_IPAuthentications($id,$ip_version,$low_ip,$low_ip,$high_ip,$aui_status,$masterDet);
					}
				}
				redirect('institutePage/addInstitute/'.$id.'?tab=5', 'refresh');
			}
			else if($this->input->post('addInstituteRefferalnext') && $id >0){
				$masterdetail=$this->Institute_model->getMasterID($id);
				$masterDet=$masterdetail[0]->m_masterid;
				$delRef_id=$this->Institute_model->deleteInstituteRefferals($masterDet);
				$ipBased=$this->input->post('ipBased');
				$referralUrl=$this->input->post('referralUrl');
				$accessToken=$this->input->post('accessToken');
				$updatedRefferalValue=$this->Institute_model->updateAccessStatues($ipBased,$referralUrl,$accessToken,$id);
			    $no_of_refs=$this->input->post('no_of_refs');
				for($i=1;$i<=$no_of_refs;$i++){
					$email_auth=$this->input->post('insEmail'.$i);
					$first_name=$this->input->post('insFirstName'.$i);
					$middle_name=$this->input->post('insMiddleName'.$i);
					$last_name=$this->input->post('insLastName'.$i);
					if(!empty($email_auth) && !empty($first_name) && !empty($middle_name) && !empty($last_name)){
			    $this->Institute_model->add_EmailAuthentication($masterDet,$email_auth,$first_name,$middle_name,$last_name);
					}
				}
				redirect('institutePage/addInstitute/'.$id.'?tab=6', 'refresh');
			}
			else if($id > 0){
					$this->load->model('Institute_model');
			$User_data = $this->Institute_model->get_Institute($id);
			$master_id=$User_data[0]->m_masterid;
			$licence_type=$User_data[0]->m_licence_type;
			if($licence_type=='IPBased'){
				$data['ip_detail']='IPBased';
			$data['email_detail']='';
			}else if($licence_type=='Multi'){
				$data['ip_detail']='';
			$data['email_detail']='Multi';
			}else if($licence_type!=''){
				$licence=explode(",",$licence_type);
				$data['ip_detail']=$licence[0];
			$data['email_detail']=$licence[1];
			}
			else{ 
				$data['ip_detail']='';
			$data['email_detail']='';
			}
			
			$data['id']=$id;
			$data['masterid']=$User_data[0]->m_masterid;
			$data['sub_id']=$User_data[0]->m_subcustid;
			$data['cust_type']=$User_data[0]->m_custtype;
			$data['lablename']=$User_data[0]->m_lablename;
			$data['firstname']=$User_data[0]->m_firstname;
			$data['lastname']=$User_data[0]->m_lastname;
			$data['primarymail']=$User_data[0]->m_primaryemail;
			$data['onlinemale']=$User_data[0]->m_onlineemail;
			$data['admin']=$User_data[0]->admin_id;
			$data['adminstatus']=$User_data[0]->status;
			//print_r($data['status']); di
			//print_r($data['adminid']); die;
			$adminid=$this->Institute_model->get_Admin($data['admin']);
			$data['admin_id']=$adminid[0]->id;
			$data['admin_firstname']=$adminid[0]->m_firstname;
			$data['admin_lastname']=$adminid[0]->m_lastname;
			//$data['status']=$adminid[0]->status;
			
			$data['subscriptions']=$this->Institute_model->get_AllSubscriptions($master_id);
				$data['allIPaddres']=$this->Institute_model->get_AllIpAddress($master_id);
				$data['allRefferals']=$this->Institute_model->get_AllEmails($master_id);
				$data['ipaddress']=$this->Institute_model->list_AllIpVersions();
				$data['status']=$this->Institute_model->list_Status();
				$data['allAccessToken']=$this->Institute_model->get_AllAccessTokens($id);
		       	$this->load->pagetemplate('addInstitute_form',$data);  
			}
		}
    }  



   
	
	###############Function for view Institutes
	public function InstituteList($id='')
	{
		$sortBy = $this->input->get('sortby');
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Institute_model');
			$searchMastercustomerid = $this->input->post('mastercustomerid');
			$searchOrder = $this->input->post('orederid');
			$searchLablename = $this->input->post('lablename');
			$data['users'] = $this->Institute_model->list_Institute($this->userid,$searchMastercustomerid,$searchOrder,$searchLablename,$sortBy,$id);
			$data['mastercustomerid']=$searchMastercustomerid;
			$data['orederidSearchValue']=$searchOrder;
			$data['lablenameValue']=$searchLablename;
			$this->session->set_userdata('last_url','');
			$data['userInfo'] = $this->userinfo();
			$this->session->set_flashdata('msg', '');
			$this->load->pagetemplate('Institute_list',$data);
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
		$this->session->set_flashdata('msg', 'Institute Deleted');
		redirect('institutePage/InstituteList', 'refresh');
		}
	}		
	############Function for uploading logo
	public function do_upload()
	{
		//print_r($_FILES['userfile']);
		$target_dir = "./uploads/";
		$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
		move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file);
    } 
    ############################Function For checking whether given institute Id is already exist in table or not
    public function checkInstituteID()
    {
    	if($this->input->is_ajax_request()) {
    	$instituteCode=$this->input->post('instituteCode');
    	$numRows=$this->Institute_model->getInstituteDetails($instituteCode);
		//echo '<pre>'; print_r($numRows); die;
    	if($numRows>0)
    		echo true;
    	}
    	else {
    		echo false;
    	}
    }
   ###################Function for Checking Institute Email Id Whether Exist Or Not
    public function checkInstituteEmailID(){
    	if($this->input->is_ajax_request()) {
    		$adminEmail=$this->input->post('adminEmail');
    		$numRows=$this->Institute_model->getInstituteAdminEmail($adminEmail);
    		if($numRows>0)
    			echo true;
    	}
    	else {
    		echo false;
    	}
    	
    }
   ##################Function for Checking User Name Whether Exist Or Not
   public function checkInstituteUserName(){
   	if($this->input->is_ajax_request()) {
   		$adminUserName=$this->input->post('adminUserName');
   		$numRows=$this->Institute_model->getInstituteAdminUserName($adminUserName);
   		if($numRows>0)
   			echo true;
   			else {
   				echo false;
   			}
   	}
 }
 #############################Function For Checking IP Range Of existing Institute
 ##################Function for Checking User Name Whether Exist Or Not
 public function checkIPRange(){
 	if($this->input->is_ajax_request()) {
 		$IPRangeValue=$this->input->post('IPRangeValue');
 		$numRows=$this->Institute_model->getInstituteIPRangeValue($IPRangeValue);
 		if($numRows>0)
 			echo true;
 			else {
 				echo false;
 			}
 	}
 }
}
