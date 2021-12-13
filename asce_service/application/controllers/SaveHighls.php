<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

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
 
 
class saveHighls extends REST_Controller {

	private $book_id;
	private $vol_id;
    private $user_id;
	
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
        $this->load->model('Highlights_m');
        //$this->authenticate();
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->helper(array('form', 'url'));
        $this->load->library('encrypt');
        $this->load->helper('html');
		$this->load->library('excel_reader');
		$this->cus_book_id = $this->session->userdata('book_id');
		$this->vol_id = $this->session->userdata('vol_id');
		$this->book_id = $this->session->userdata('book_id');
        $this->user_id = $_SESSION['user_id'];
		
		
	    
    }
	
	
    
    // Add users highlights
	/* function retrivehighlights(){
		$highlight_chapterId = $this->input->post('chapid');
		$this->load->model('Highlights_m');
		
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
	
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else if(($this->input->post('chapid')) == '')
		{

			$this->load->model('Highlights_m');
			$chid="";
			$data= $this->Highlights_m->getChapters($this->input->post('chapid'),$this->cus_book_id,$this->user_id);
         	$highlightsdetails = $this->response($data, 200);
		}
		else
		{
			$this->load->model('Highlights_m');
			$data= $this->Highlights_m->retrivehighlights($this->input->post('chapid'),$this->cus_book_id,$this->user_id);
         	$highlightsdetails = $this->response($data, 200);
		}
		
		
		
	} */
    function savedata_post()
	{
		$highlight_chapterId = $this->input->post('chapterId');
		$highlight_paraData = $this->input->post('paraData');
		$highlight_paraId = $this->input->post('paraId');
		$highlight_sectionId = $this->input->post('sectionId');
		
       if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
		 	$this->response(array('error' => 'Sorry User not logged in'));
		}
        else
		{
			$this->load->model('Highlights_m');
			$high['Highlight'] = $this->Highlights_m->addhighlight($this->cus_book_id,$highlight_chapterId,$highlight_paraData,$highlight_paraId,$highlight_sectionId,$this->user_id);
			$entiredetails = $this->response(array($this->input->post()), 200);
			
		}
        
    }
	// Both Get and Post method
    function savedata_get(){
		$this->savedata_post();
	}
	
	// Retrive Highlights
	function retrivehighlights_post(){
		$masterId=$this->master_id = $this->session->userdata('master_id');
		$userinfo=$this->userinfo = $this->session->userdata('userinfo');
		$email=$this->email = $this->session->userdata('OnlineEmailAddress');
		
	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
		$this->response(array('error' => 'Sorry User not logged in'));
		}
		else if(($this->input->post('chapid')) == '')
		{	
		$this->load->model('Highlights_m');
		$chid="";
		$data= $this->Highlights_m->retrivehighlights($this->input->post('chapid'),$this->cus_book_id,$this->user_id);
		$highlightsdetails = $this->response($data, 200);
		}
		else
		{
			
			/* $this->load->model('Notes_m');
			if($userinfo=="subuser"){
			$data= $this->Notes_m->retrivenotesPublic($this->input->post('chapid'), $this->cus_book_id,$masterId);
			print_r($data);
			die();
			}	 */
		$this->load->model('Highlights_m');
		$data= $this->Highlights_m->retrivehighlights($this->input->post('chapid'),$this->cus_book_id,$this->user_id);
		$highlightsdetails = $this->response($data, 200);
		}
		
	}
	
	// Both Get and Post method
	function retrivehighlights_get(){
		$this->retrivehighlights_post();
	}

	// Delete Highlights
	function deletehighlights_post(){
		$high_delid = $this->input->post('highdeleteid');
	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else
		{
			$this->load->model('Highlights_m');
			$data= $this->Highlights_m->deletehighlights($this->user_id,$this->cus_book_id,$this->input->post());
            $notesdetails = $this->response($data, 200);
			
		}
	}
    
    function deletehighlights_get(){
		$this->deletehighlights_post();
	}
	/*-------------------------------For Update Highlight-----------------------------*/
	// Delete Highlights
	function UpdateHightLight_post(){
		$color_code = $this->input->post('code');
		 
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->response(array('error' => 'Sorry User not logged in'));
		}
		else
		{
			$this->load->model('Highlights_m');
			$data= $this->Highlights_m->UpdateHightLight($color_code);
			$notesdetails = $this->response($data, 200);
				
		}
	}
	
	function UpdateHightLight_get(){
		$this->UpdateHightLight_post();
	}
	/*--------------------------------------End----------------------------------------*/
   
}