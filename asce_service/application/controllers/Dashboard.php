<?php
error_reporting(0);
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
class Dashboard extends MY_Controller  {

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
		$this->load->model('Dashboard_model');
		$this->parse_data = array();
		$this->masterId = array();
		$this->load->database();
		$this->userid = $this->session->userdata('user_id');

		
    }
	
	public function index()
    {
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
	        $this->list_custumbook();
		}
    }    
	
	// Function to get user info
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
	
	// Function to show a custom book
	public function show_dashboard()
    {
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			
			$this->load->model('Dashboard_model');
			$this->session->set_userdata('last_url','');
			$data['userInfo'] = $this->userinfo();
			$data['bookDetails']=$this->Dashboard_model->getBookDetails();
			$data['productDetails']=$this->Dashboard_model->getProductDetails();
			
			$data['individualProduct']=$this->Dashboard_model->getIndividualDetails();
		//print_r($data['individualProduct']); die;
			$data['institutionalProduct']=$this->Dashboard_model->getInstitutionalDetails();
			$data['subscribedInstitute']=$this->Dashboard_model->getAllInstitute();
			$data['totalIPBased']=$this->Dashboard_model->getAllIPBased();
			$data['emailBased']=$this->Dashboard_model->getAllEmailBased();
			$data['emailBasedcount']=$this->Dashboard_model->get_multiuser();
			//echo "<pre>";print_r($data['subscribedInstitute']); die;
			
			
			$newusersarray = array();
			//echo'<pre>';print_r($data['users']); die;
			foreach($data['emailBasedcount'] as $newvalue){
					$newusersarray[$newvalue->m_orderid] = $newvalue;
			}
			
			//echo'<pre>';print_r($data['users']); echo "<hr>";
			foreach($data['emailBased'] as $frnkey=>$filteredresult){
				if (array_key_exists($filteredresult->m_orderid, $newusersarray)) {
					$data['users'][$frnkey] = $newusersarray[$filteredresult->m_orderid];
				}
			}
			
			
			//in_array();
			//echo'<pre>';print_r($data['users']); die;
			//remove duplicates
			$finalarrayforusers = array();
			foreach($data['emailBased'] as $frnkey=>$filteredresult){
				
					$finalarrayforusers[$filteredresult->m_orderid] = $filteredresult;
				
			}
			$data['emailBased'] = count($finalarrayforusers);
			
			
			//echo'<pre>';print_r(count($data['emailBased'])); die;
			
			$data['emailipBased']=$this->Dashboard_model->getAllEmailIpBased();
			$data['subscribedUser']=$this->Dashboard_model->getAllUsers();
			//print_r($data['totalIPBased']); die;
			$data['InstituteUser']=$this->Dashboard_model->getInstituteUsers();
			
			$this->load->pagetemplate('Dashboard',$data); 
		}
    } 
	
}