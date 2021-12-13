<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Book extends REST_Controller {
	private $book_id;
	private $vol_id;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
        $this->load->database();
        $this->load->model('Book_m');
	$this->load->library('session');
        //$this->authenticate();
        $this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->helper(array('form', 'url'));
        $this->load->library('encrypt');
        $this->load->helper('html');
		//$this->load->library('form_validation');
		$this->load->library('excel_reader');
		//$this->load->library('reader');
		$this->vol_id = $this->session->userdata('vol_id');
	    $this->book_id = $this->session->userdata('book_id'); 
		$this->cus_book_id = $this->session->userdata('cus_book_id');
		$this->book_type = $this->session->userdata('book_type');
		$this->login = $this->session->userdata('login');
    }
   
   function logout_post(){
		$this->tank_auth->logout();
                $session_id = $_SESSION['sesionidvalue'];
                if(!empty($session_id)){
                $this->load->model('Book_m');
                $this->Book_m->deleteLoggedInfo($session_id);
                }
		$this->response(array('success' => 'User logged out'));
   }
   function logout_get(){
		$this->logout_post();
   }
    
	// Get userinfo, book and chapter details
	function appdata_get(){
		
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
			{
			   //redirect ('/auth/login');
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else
		{
			
			$this->load->model('Book_m');
			$data['User Info'] = $this->Book_m->userinfo_get();
			$data['Book Details'] = $this->Book_m->bookdetails_get();
			$data['Chapter Details'] = $this->Book_m->chapterdetails_get();
	        $entiredetails = $this->response($data, 200);
		}
	}
	
	
	// Retrive Content
	function contentdetails_post(){
		
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
	
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else if(($this->input->post('cnttype')) == '')
		{

			$this->load->model('Book_m');
			$cntype="";
			$cnt_search = $this->input->post('cont_search');
			$data= $this->Book_m->contentdetails_get($cntype,$cnt_search);
         	$contentdetails = $this->response($data, 200);
		}
		else
		{
			$this->load->model('Book_m');
			$cnt_search = $this->input->post('cont_search');
			$data= $this->Book_m->contentdetails_get($this->input->post('cnttype'),$cnt_search);
         	$contentdetails = $this->response($data, 200);
		}
	}
	
	function contentdetails_get(){
		$this->contentdetails_post();
	}
	
	function chapandsec_get(){
		$bokvolno = $this->session->userdata('volumeno');
		$section = array();
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
			{
			   //redirect ('/auth/login');
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else{
			$this->load->model('Book_m');
			/*----------------------------- For Single User--------------------------*/
			if($this->book_type == "SINGLE"){
				$data['ChapterDetails'] = $this->Book_m->chapters_get($this->vol_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContents($this->book_id);
				$sectionDetails = $this->Book_m->sectiondetails_get($this->vol_id);
			}
			/*----------------------------------For Multi User--------------------------*/
			else if($this->book_type == "MULTI"){
				$data['ChapterDetails'] = $this->Book_m->chapters_get($this->vol_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContents($this->book_id);
				$sectionDetails = $this->Book_m->sectiondetails_get($this->vol_id);
			}
			/*---------------------------------- for IPBased--------------------------------*/
			else if($this->book_type == "IPBASED"){
				$data['ChapterDetails'] = $this->Book_m->chapters_get($this->vol_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContents($this->book_id);
				$sectionDetails = $this->Book_m->sectiondetails_get($this->vol_id);
			}
			/*------------------------------------For Admin-----------------------------------*/
			else if($this->book_type == "PRIMARY"){
				$data['ChapterDetails'] = $this->Book_m->chapters_get($this->vol_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContents($this->book_id);
				$sectionDetails = $this->Book_m->sectiondetails_get($this->vol_id);
			}
			/*------------------------------------For Custom Book--------------------------------*/
			else if($this->book_type == "CUSTOM"){
				$data['ChapterDetails'] = $this->Book_m->custom_chapters_get($this->cus_book_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContents($this->book_id);
				$sectionDetails = $this->Book_m->custom_sectiondetails_get($this->cus_book_id);
			}

			foreach($sectionDetails as $row){
				$section[$row->secLevel][$row->secMasterId][] = $row ;
			}
			$data['SectionDetails'] = $section;
			$data['RawSection'] = $sectionDetails;
			$chapandsec = $this->response($data);
			
            
		}
	}
	
	function chapandsec_post(){
			return $this->chapandsec_get();            
	}
	/*----------------------------------------------For Dynamic Loading------------------------------------------*/
	function chapandsecDynamic_get(){
		$searchType = $this->input->post('searchType');
		$bokvolno = $this->session->userdata('volumeno');
		$section = array();
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			//redirect ('/auth/login');
			$this->response(array('error' => 'Sorry User not logged in'));
		}
		else{
			$this->load->model('Book_m');
			/*--------------------------- For Single User-------------------------------------------------------*/
			if($this->book_type == "SINGLE"){
				$data['ChapterDetails'] = $this->Book_m->chapters_get($this->vol_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContentsDynamic($this->book_id,$searchType);
				$sectionDetails = $this->Book_m->sectiondetails_get($this->vol_id);
			}
			/*--------------------------For Multi User----------------------------------------------------------*/
			else if($this->book_type == "MULTI"){
				$data['ChapterDetails'] = $this->Book_m->chapters_get($this->vol_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContentsDynamic($this->book_id,$searchType);
				$sectionDetails = $this->Book_m->sectiondetails_get($this->vol_id);
			}
			/*------------------------------For IPBased----------------------------------------------------------*/
			else if($this->book_type == "IPBASED"){
				$data['ChapterDetails'] = $this->Book_m->chapters_get($this->vol_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContentsDynamic($this->book_id,$searchType);
				$sectionDetails = $this->Book_m->sectiondetails_get($this->vol_id);
			}
			/*----------------------------------For Admin---------------------------------------------------------*/
			else if($this->book_type == "PRIMARY"){
				$data['ChapterDetails'] = $this->Book_m->chapters_get($this->vol_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContentsDynamic($this->book_id,$searchType);
				$sectionDetails = $this->Book_m->sectiondetails_get($this->vol_id);
			}
			/*-----------------------------------------For Custom Book----------------------------------------------*/
			else if($this->book_type == "CUSTOM"){
				$data['ChapterDetails'] = $this->Book_m->custom_chapters_get($this->cus_book_id);
				$data['historyContents'] = $this->Book_m->getAllHistoryContentsDynamic($this->book_id,$searchType);
				$sectionDetails = $this->Book_m->custom_sectiondetails_get($this->cus_book_id);
			}
	
			foreach($sectionDetails as $row){
				$section[$row->secLevel][$row->secMasterId][] = $row ;
			}
			$data['SectionDetails'] = $section;
			$data['RawSection'] = $sectionDetails;
			$chapandsec = $this->response($data);
				
	
		}
	}
	
	function chapandsecDynamic_post(){
		return $this->chapandsecDynamic_get();
	}
	/*---------------------------------------------------End-----------------------------------------------------*/
	/*----------------------------------Methods For History Panel----------*/
        function contentList_get(){
		$bokvolno = $this->session->userdata('volumeno');
		$section = array();
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
			{
			   //redirect ('/auth/login');
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else{
			$this->load->model('Book_m');
			$historyData = $this->Book_m->getAllHistoryContents();
			$data['historyContents'] = $historyData;
			$historyData = $this->response($data);
		}
	}
	
	function contentList_post(){
			return $this->contentList_get();            
	}
        /*-------------------------------------------End------------------------*/
	function printsec_post(){
	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
			{
			   //redirect ('/auth/login');
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else{
			
			$this->load->model('Book_m');
			//$chapterDetails = $this->Book_m->printchap_get();
			$sectionDetails = $this->Book_m->printsec_get();	
			$temp = array();
			$data = array();
			foreach($chapterDetails as $row){
				$temp[]= array("chapId"=>$row->chapId,"chapTitle"=>$row->chapTitle);
			}
			foreach($temp as $item){				
				foreach($sectionDetails as $row){										
					if($item['chapId'] == $row->chapId){						
						$item['section'][] = $row;	
					}
				}
				$data []= $item; 
			}
			$chapandsec = $this->response($data);            
		}
	
	}

	
	    
    // Requested URL is incorrect this function will displays error
    
    function index_get(){
       
	   $index = $this->response(array('error' => 'URL requested is not found'), 404);
    }
	
	//Get Book details
	
	function bookdetails_get(){
	
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
			{
			   //redirect ('/auth/login');
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else{
			$this->load->model('Book_m');
			$data = $this->Book_m->bookdetails_get($this->book_id,$this->vol_id);
	        $bookdetails = $this->response($data);
		}
	}
	
	function bookdetails_post(){
	
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
			{
			   //redirect ('/auth/login');
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else
			{
			$isbn = $this->input->post('isbn');
			$volNo = $this->input->post('volNo');
			$this->load->model('Book_m');
			$data = $this->Book_m->bookdetails_get($this->book_id,$this->vol_id);
	        $bookdetails = $this->response($data);
		}
	}	
	
	function chapters_get(){
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
		else
		{
			$this->load->model('Book_m');
			$data = $this->Book_m->chapters_get();
			$userinfo = $this->response($data);
		}
	}
	
	//Get section details
	
	function sectiondetails_get(){
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
		else
		{
		$this->load->model('Book_m');
        $data = $this->Book_m->sectiondetails_get();
        $userinfo = $this->response(array('Section  Details' => $data, 200));
		}
	}
    
    // Navigation Section function
    
    function navigatesec_post(){
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
		else
		{
		$this->load->model('Book_m');
		/*-------------------------------For Single--------------------------------------*/
		if($this->book_type == "SINGLE"){
			$data = $this->Book_m->navigatesec_get($this->vol_id);
		}
		/*-----------------------------For Multi-------------------------------------------*/
		else if($this->book_type == "MULTI"){
			$data = $this->Book_m->navigatesec_get($this->vol_id);
		}
		/*---------------------------------------For IPBased---------------------------------*/
		else if($this->book_type == "IPBASED"){
			$data = $this->Book_m->navigatesec_get($this->vol_id);
		}
		/*----------------------------------------For Admin------------------------------------*/
		else if($this->book_type == "PRIMARY"){
				$data = $this->Book_m->navigatesec_get($this->vol_id);
			}
		/*----------------------------------------------For Custom-------------------------------*/	
			else if($this->book_type == "CUSTOM"){
				$data = $this->Book_m->custom_navigatesec_get($this->cus_book_id);
			}
        
        
		//$userinfo = $this->response(array($data));
                        //echo "<pre>dsfdsfd";print_r($data);die;
                        $temparray = array();
                        $temparrayFinal = array();
                        $keyvalue = array();
                        $data1 = $data;
                        foreach ($data as $key => $value) {
//                            $CommentrySection = substr($value->m_seclabel,0,1);
//                            if($CommentrySection=='C'){
//                                continue;
//                            }
                            $CommentrySectionLink = substr($value->m_seclinkpage,-1);
                            
                            if($CommentrySectionLink=='v'){
                                continue;
                            }
                            if(preg_match("/[a-z]/i", $value->m_seclabel)){
                                continue;
                            }
                           $temparray[$value->m_seclabel]=$value;
                        }
                        $datavalueew = array_keys($temparray);
                        natsort($datavalueew);
                        foreach($datavalueew as $datakeyIp){
                           $temparrayFinal[] = $temparray[$datakeyIp];
                        }
                        $userinfo = $this->response(array($temparrayFinal));
		}
	}
	
	function navigatesec_get(){
		$this->navigatesec_post();
	}
	
	//Get chapter details
	function chapterdetails_get(){
	
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
		else
		{
			$this->load->model('Book_m');
			$datas = $this->Book_m->chapterdetails_get();
			$chapter = array();
			$section = array();
			$lastChapId = 0;
			foreach($datas as $data){
				if($lastChapId != $data->m_chpid){
					$chapter[$data->m_chpid] = $data;
					$lastChapId = $data->m_chpid;
				}
				$section[$data->m_seclevel][] = $data;
			}
			foreach($section as $sec){
				$cnt = 0;
				foreach($sec as $row){
					$chapter[$row->m_chpid]->sublevel[$cnt] = $row;
					//print_r($chapter[$row->m_chpid]->sublevel); echo"</br>";
//echo"</br>";
				$cnt++;
				}
				
			}
			$data = array();
			//print_r($section);
			//die;
			//$data->chapters = $chapter;
			//$data['section'] = $section;
			$data['chapters'] = $chapter;
			//print_r($data);
			$chapdetails = $this->response(array($chapter, 200));
		}
	}
	
	function get_app_info_post(){
		$this->book_type = $this->session->userdata('book_type');
		$this->login = $this->session->userdata('login');
		$userinfo = $this->response(array('book_type'=>$this->book_type,'login'=>$this->login));
	}
    
    // Get user response
   	function userinfo_get()
    {
		$userid = $this->session->userdata('user_id');
      
       if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
       else
       {
        $this->load->model('Book_m');
        $data = $this->Book_m->userinfo_get($userid);
        $userinfo = $this->response($data);
       }
    }
	
   	function userinfo_post()
    {
		$userid = $this->session->userdata('user_id');
		 
       if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
       else
       {
        $this->load->model('Book_m');
        $data = $this->Book_m->userinfo_get($userid);
        $userinfo = $this->response($data);
       }
     }

   function subuserinfo_post()
    {
		$email = $this->session->userdata('OnlineEmailAddress'); 
		$orderid = $this->session->userdata('orderid');
       if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
        else if($email!="IPBASED")
       {
		   
        $this->load->model('Book_m');
        $data = $this->Book_m->subuserinfo_gets($email);
		//print_r($data[0]->m_licence_type); die;
		
        $userinfo = $this->response($data);
       }
	    else if($email=="IPBASED")
	   {
		   //echo"hello".$orderid ; die;
		  $this->load->model('Book_m');
         $data = $this->Book_m->subuserorderinfo_gets($orderid); 		 
		 $userinfo = $this->response($data);
		 //echo $userinfo; die;
	   }
    }    
	
	
	 function subuserComoninfo_post()
    {
		$email = $this->session->userdata('OnlineEmailAddress'); 
       if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
       else
       {
        $this->load->model('Book_m');
        $data = $this->Book_m->subuserComoninfo_gets($email);
        $userinfo = $this->response($data);
       }
    }    
	
	
	
	
	// Get the session details
    function ses_get()
    {
        if(!$this->tank_auth->is_logged_in(TRUE)) //Users not logged in
        {
            //redirect ('/auth/login');
            $this->response(array('error' => 'Sorry User not logged in'), 404);
        }
        else
        {
             $ses = $this->Book_m->ses_get();
             $ses = $this->response($ses, 200); 
        }
    }
	
	// Get user information
	function user_get()
    {
        if(!$this->tank_auth->is_logged_in(TRUE)) //Users not logged in
        {
            //redirect ('/auth/login');
            $this->response(array('error' => 'Sorry User not logged in'), 404);
        }
           
        else
        {
            $user = $this->Book_model->field_get();
          // print_r($field);
          // echo $student_id = $field->row()->email;
           $my_values = array();
            foreach($user as $row)
            {
               $username = $my_values[] = $row->email;
               $token = $my_values[] = $row->token;
               $password = $my_values[] = $row->password;

            }
        $encode = $this->encrypt->encode($token .$username. $password. time());
        if ($encode)
        {
            $this->response($encode, 200); // 200 being the HTTP response code
        }

        else
        {
            echo $this->response(array('error' => 'User could not be found'), 404);
        }
        }
    }

	// Post use information
    function user_post()
    {
        // $this->some_model->update_user($this->get('id'));
        $message = array(
            'id' => $this->get('id'),
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'message' => 'Added a resource'
        );

        $this->response($message, 201); // 201 being the HTTP response code
    }

    function user_delete()
    {
        // $this->some_model->delete_something($this->get();
        $message = array(
            'id' => $this->get('id'),
            'message' => 'Deleted the resource'
        );

        $this->response($message, 204); // 204 being the HTTP response code
    }

    public function send_post()
    {
        var_dump($this->request->body);
    }

    public function send_put()
    {
        var_dump($this->put('foo'));
    }
}
