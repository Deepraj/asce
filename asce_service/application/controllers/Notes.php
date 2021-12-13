<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Notes extends REST_Controller {
	
	private $book_id;
	private $vol_id;
    private $user_id;
	public $master_id;
	public $email;
    public $userinfo;
	
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
        $this->load->model('Notes_m');
		$this->load->model('Highlights_m');
        $this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->helper(array('form', 'url'));
        $this->load->library('encrypt');
        $this->load->helper('html');
		$this->load->library('excel_reader');
		$this->cus_book_id = $this->session->userdata('book_id');
		$this->vol_id = $this->session->userdata('vol_id');
		$this->book_id = $this->session->userdata('book_id');
		$this->master_id = $this->session->userdata('master_id');
		$this->orderid = $this->session->userdata('orderid');
		$this->email = $this->session->userdata('OnlineEmailAddress');
		$this->userinfo = $this->session->userdata('userinfo');
        $this->user_id = $_SESSION['user_id'];
    }
    
    // Add Notes
    function addnotes_post()
    {
		$notesecid = $this->input->post('notesecid');
        $notes_start = $this->input->post('notes_start');
		$notes_end = $this->input->post('notes_end');
		$notes_tagname = $this->input->post('tag_name');
		     // $notes_tagname = strtolower($notes_tagname);
		$notes_targetid = $this->input->post('target_id');
		$notes_content = $this->input->post('content');
		$notes_chapid = $this->input->post('chapid');
        $notes_input_content = $this->input->post('note_content');
        $notes_input_gender = $this->input->post('note_gender');
        $node_status = $this->input->post('node_status');
		$paraData=$this->input->post('paraData');
		$paraData=str_replace(' ', '&thinsp;',$paraData);
		$noteId=$this->input->post('noteId');
       $userdefine=$this->input->post('userdefine');
//echo $userdefine; die;
     if($this->input->post('userdefine')=="subuser")
        {

       $paraData =  preg_replace('/<u title=\\"public\\"[^>]+>(.*?)<\/u>/', "$1", $paraData);
     
          } 
		//echo $paraData; die;
    if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
	{
	 //redirect ('/auth/login');
	 $this->response(array('error' => 'Sorry User not logged in'));
	}
		else
		{
		$this->load->model('Notes_m');
		$data = $this->Notes_m->addnotes($notesecid,$notes_start,$notes_end,$notes_tagname,$notes_targetid,$notes_content,$notes_chapid,$notes_input_content,$notes_input_gender,$this->user_id,$this->cus_book_id,$this->master_id,$this->orderid,$this->email,$node_status,$noteId);
		$high['Highlight'] = $this->Highlights_m->addhighlight($this->cus_book_id,$notes_chapid,$paraData,$notes_targetid,$notesecid,$this->user_id);
			$entiredetails = $this->response(array($this->input->post()), 200);
		//$entiredetails = $this->response(array($this->input->post()), 200);
		}
        
    }
	
	function addnotes_get(){
	$this->addnotes_post();
	}
	
	
	function getPublicNots_post()
	{	
		$data1=$this->input->post();
		$parapubNote=array('t_txhcus_book_id' => $this->input->post('t_txncus_book_id'),
					't_txhchapid'  => $this->input->post('t_txnchpid'),
					't_txhusrid'  => $this->input->post('t_txnusrid'),
					't_txhsecid'  => $this->input->post('t_txnsecid'),
					't_txhparaid'  => $this->input->post('t_txnpgeid')
			);
		$data =(array) $this->Notes_m->getPublicNots_get($parapubNote);
		$data=array_merge($data, $data1);
		print json_encode($data);
			
	}
	// Function to update notes
	function updatenotes_post(){
	
	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
	{
	 //redirect ('/auth/login');
	 $this->response(array('error' => 'Sorry User not logged in'));
	}
		else
		{
		$this->load->model('Notes_m');
		//print_r($this->input->post());die;
		$data = $this->Notes_m->updatenotes_get($this->input->post('note_id'),$this->user_id,$this->cus_book_id);
		//$entiredetails = $this->response($data, 200);
		$high['Highlight'] = $this->Highlights_m->addhighlight($this->cus_book_id,$bookmark_chapid,$paraData,$target_id,$section_id,$this->user_id);
		$entiredetails = $this->response(array($this->input->post()), 200);
		}
	}
	
	function updatenotes_get(){
	$this->updatenotes_post();
	}
    
    // Retrive Notes
    function retrivenotes_post(){
		
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
		 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else if(($this->input->post('chapid')) == '')
		{
			$chid="";
			$this->load->model('Notes_m');
			$data= $this->Notes_m->retrivenotes($chid,$this->user_id,$this->cus_book_id,$this->master_id,$this->orderid,$this->email,$this->userinfo);
            $notesdetails = $this->response($data, 200);
		}
		else
		{
			$this->load->model('Notes_m');
			$data= $this->Notes_m->retrivenotes($this->input->post('chapid'),$this->user_id,$this->cus_book_id,$this->master_id,$this->orderid,$this->email,$this->userinfo);
			//print_r($data); die;
         	$highlightsdetails = $this->response($data, 200);
		}
		function retrivenotes_get(){
		$this->retrivenotes_post();
	}
	}
	
	
	// Delete Notes
	function deletenotes_post(){
		
		    
	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
		 $this->response(array('error' => 'Sorry User not logged in'));
		}
		else
			$noteId=$this->input->post('noteId');
			$data1['paraId']=$parent_Id=$this->input->post('parent_Id');
			$sec_id=$this->input->post('sec_id');
			$data1['chapterId']=$chap_id=$this->input->post('chap_id');
	//	echo $noteId."//".$parent_Id."//".$sec_id."///".$chap_id; die;
		{
			$data=$this->Highlights_m->gethlightsData($chap_id,$this->cus_book_id,$this->user_id,$sec_id,$parent_Id);
			//print_r($data[0]['paraData']); die;
			//$data[0]['paraData'] = preg_replace('/(>\s+<)|(>\n+<)/', ' ', $data[0]['paraData']);
			
		//$data[0]['paraData'] =	preg_replace("/(\r?\n){2,}/", "\n\n", $data[0]['paraData']);
		
		$data[0]['paraData']= preg_replace('/\s+/',' ',str_replace(array("\r\n","\r","\n"),' ',trim($data[0]['paraData'])));
			
			//print_r($data[0]['paraData']); echo $noteId; die;
			$newValue = preg_replace("/<u newhigh_id=\"".$noteId."\"[^>]+>(.*?)<\/u>/",
			"$1", $data[0]['paraData']);
			
			$data1['paraData']=$newValue;
			//print_r($data1['paraData']); echo $noteId; die;
			$ResData[]=$data1;
			$high['Highlight'] = $this->Highlights_m->addhighlight($this->cus_book_id,$chap_id,$newValue,$parent_Id ,$sec_id,$this->user_id);
			//$this->load->model('Notes_m');
			$data= $this->Notes_m->deletenotes($this->user_id,$this->cus_book_id,$noteId);
           echo $notesdetails = $this->response($ResData, 200);
		}
	}
}