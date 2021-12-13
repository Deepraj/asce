<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Searchcontent extends REST_Controller {
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
		$this->serchLength = 10;
        $this->load->database();
        $this->load->model('Searchcontent_m');
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
		$this->load->model('Searchcontent_m');
		$this->cus_book_id = $this->session->userdata('cus_book_id');
		$this->book_type = $this->session->userdata('book_types');
		
    }
   
    
	// Retrive Content
	function contentdetails_post(){
		//echo "<pre>" ;print_r($cnt_search['page_seach']); die;
		//echo $this->session->userdata('book_type'); die;
		$cnt_search = $this->input->post('cont_search');
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
	
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		//            chapter_search


		
		else if(($cnt_search['chapter_search']=='All' && $cnt_search['advanceSearchStatus']=='off' ) || ($cnt_search['advanceSearchStatus']=='on' && $cnt_search['chapter_search']=='All')  || ($cnt_search['advanceSearchStatus']=='on' && $cnt_search['chapter_search']!='Selected') || ($cnt_search['advanceSearchStatus']=='off' && $cnt_search['figure_caption']=='true' || $cnt_search['table_caption']=='true' || $cnt_search['table_content']=='true' || $cnt_search['reference'] == 'true' || $cnt_search['appendixes'] == 'true' ) )
		{
			//echo "sdsdsdsds"; die;
			$data = array();
			if($cnt_search['figure_caption'] == 'false' and  $cnt_search['table_caption'] == 'false' and  $cnt_search['table_content'] == 'false' and  $cnt_search['reference'] == 'false' and  $cnt_search['appendixes'] == 'false' and  $cnt_search['front_matter'] == 'false' ){
				$data= $this->Searchcontent_m->normalSearch_get($cnt_search,$this->serchLength,$this->vol_id,$this->book_type,$this->cus_book_id);
			}
			else{
				
				
				$data= $this->Searchcontent_m->normalSearch_refine($cnt_search,$this->serchLength,$this->vol_id,$this->book_type,$this->cus_book_id);
			}
			
			/*if($cnt_search['figure_caption'] == 'false' and  $cnt_search['table_caption'] == 'false' and  $cnt_search['table_content'] == 'false' and  $cnt_search['reference'] == 'false' and  $cnt_search['appendixes'] == 'false' and  $cnt_search['front_matter'] == 'false' and $this->book_type == "CUSTOM"){
			
				$data= $this->Searchcontent_m->normalcustomSearch_get($cnt_search,$this->serchLength,$this->cus_book_id,$this->vol_id);
			}
			else{
				$data= $this->Searchcontent_m->normalcustomSearch_refine($cnt_search,$this->serchLength,$this->cus_book_id,$this->vol_id);		
			}*/
			
         	$this->response($data, 200);
		}else{
			//echo"d"; die;
			$data= $this->Searchcontent_m->advanceSearch($cnt_search,$this->serchLength,$this->vol_id,$this->book_type,$this->cus_book_id);
         	$this->response($data, 200);
		}
	}
	
	function contentdetails_get(){
		$this->contentdetails_post();
	}
}
