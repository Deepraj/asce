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
class Bookmarks extends REST_Controller {
	private $book_id;
	private $vol_id;
	private $chapter_id;
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
        $this->load->model('Bookmarks_m');
		$this->load->model('Highlights_m');
        //$this->authenticate();
		$this->load->library('session');
        $this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->helper(array('form', 'url'));
        $this->load->library('encrypt');
		//$this->load->library('simple_html_dom');
        $this->load->helper('html');
		//$this->load->library('form_validation');
		$this->load->library('excel_reader');
		//$this->load->library('reader');
		$this->vol_id = $this->session->userdata('vol_id');
		$this->book_id = $this->session->userdata('book_id');
		$this->cus_book_id = $this->session->userdata('book_id');
        $this->user_id = $_SESSION['user_id'];
        
    }
    
    // Add users Bookmarks
    function addbookmark_post()
    {
		$bookmark_chapid = $this->input->post('chapid');
		$bookmark_title = $this->input->post('bookmark_title');
		$section_id = $this->input->post('bmksecid');
		$bookmark_start = $this->input->post('bookmark_start');
		$bookmark_end = $this->input->post('bookmark_end');
		$tag_name = $this->input->post('tag_name');
		$target_id = $this->input->post('target_id');
		$content = $this->input->post('content');
		$paraData = $this->input->post('paraData'); 
		$bookmarkSecId= $this->input->post('bookmarkSecId'); 
		
		
      if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
	  {
	    $this->response(array('error' => 'Sorry User not logged in'));
	  }
        else
		{
			$this->load->model('Bookmarks_m');
			$high['Bookmark'] = $this->Bookmarks_m->addbookmark($bookmark_chapid,$bookmark_title,$section_id,$bookmark_start,$bookmark_end,$tag_name,$target_id,$content,$this->user_id,$this->cus_book_id,$bookmarkSecId);
			//$this->load->Highlights_m->
			$high['Highlight'] = $this->Highlights_m->addhighlight($this->cus_book_id,$bookmark_chapid,$paraData,$target_id,$section_id,$this->user_id);
			$entiredetails = $this->response(array($this->input->post()), 200);
			//$entiredetails = $this->response($high, 200);
		}
        
    }
    function addbookmark_get(){
		$this->addbookmark_post();
	}
	
	// Retrive users Bookmarks
	function retrivebookmark_post(){
		
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
			{
			 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else if(($this->input->post('chapid')) == '')
		{
			$chid="";
			$this->load->model('Bookmarks_m');
			$data= $this->Bookmarks_m->retrivebookmark($chid,$this->user_id,$this->cus_book_id);
            $bookmarkdetails = $this->response($data, 200);
		}
		else
		{
			$this->load->model('Bookmarks_m');
			$data= $this->Bookmarks_m->retrivebookmark($this->input->post('chapid'),$this->user_id,$this->cus_book_id);
            $bookmarkdetails = $this->response($data, 200);
		}
	}
	
	function retrivebookmark_get(){
		$this->retrivebookmark_post();
	}
	
	// Delete users Bookmarks
	function deletebookmark_post(){
	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
		 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else
		{	$bookmarkId=$this->input->post('bookmarkId');
			$data1['paraId']=$parent_Id=$this->input->post('parent_Id');
			$sec_id=$this->input->post('sec_id');
			$data1['chapterId']=$chap_id=$this->input->post('chap_id');
			$data=$this->Highlights_m->gethlightsData($chap_id,$this->cus_book_id,$this->user_id,$sec_id,$parent_Id);
			$data[0]['paraData']= preg_replace('/\s+/',' ',str_replace(array("\r\n","\r","\n"),' ',trim($data[0]['paraData'])));
			
			$newValue = preg_replace("/<mark newhighbook_id=\"".$bookmarkId."\"[^>]+>(.*?)<\/mark>/",
			"$1", $data[0]['paraData']);
			$data1['paraData']=$newValue;
			$ResData[]=$data1;
			$high['Highlight'] = $this->Highlights_m->addhighlight($this->cus_book_id,$chap_id,$newValue,$parent_Id ,$sec_id,$this->user_id);
			$data= $this->Bookmarks_m->deletebookmark($this->user_id,$this->cus_book_id,$bookmarkId);
			
            $notesdetails = $this->response($ResData,  200);
		}
	}
	
	function getTextBetweenTags($string, $tagname) {
    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    return $matches[1];
	}


}