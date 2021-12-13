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
class Custombook_library extends CI_Controller  {

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
		$this->load->model('custombook_model');
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
	
	function custom_booksearch()
	{
	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{	
	$this->load->model('custombook_model');	
	$search = $this->input->post('custom_titlesearch');
	$from_date = $this->input->post('search_from_date');
	$to_date = $this->input->post('search_to_date');	
	$data['books'] = $this->custombook_model->custom_booksearch($search,$from_date,$to_date);
	$this->session->set_userdata('last_url','');
	$data['userInfo'] = $this->userinfo();
	$this->load->pagetemplate('custom_booklist', $data);
		}
	}
	
	public function show_custombook()
    {
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->session->set_userdata('last_url','');
			$data['userInfo'] = $this->userinfo();
			$data['custom_titlesearch'] = array(
				'name'	=> 'custom_titlesearch',
				'id'	=> 'custom_titlesearch',
				'value'	=> set_value('custom_titlesearch'),
				'maxlength'	=> 80,
				'size'	=> 30,
				'for' => "customTitle",
				'class' => "form-control",
				'placeholder'=>"Search for...",
			);
			
			$data['search_from_date'] = array( 
				'name'	=> 'search_from_date',
				'id'	=> 'search_from_date',
				'value'	=> set_value('search_from_date'),
				'for' => "search Date From",
				'class' => "form-control datepicker",
				'maxlength'	=> 5,
				'size'  => "13",
				'placeholder'=>"From",
			);

			$data['search_to_date'] = array(
				'name'	=> 'search_to_date',
				'id'	=> 'search_to_date',
				'value'	=> set_value('search_to_date'),
				'for' => "Search Date To",
				'class' => "form-control datepicker",
				'maxlength'	=> 5,
				'size'  => "13",
				'placeholder'=>"To",
			);
			
			$this->form_validation->set_rules('custom_titlesearch','Custom Book Title','trim|required');
			$this->form_validation->set_rules('search_from_date','Search Date From','trim|required');
			$this->form_validation->set_rules('search_to_date','Search Date To','trim|required');
			
			if($this->form_validation->run() == FALSE)
			{
				$this->load->model('Custombook_model');
				$search = $this->input->post('custom_titlesearch');
				$from_date = $this->input->post('search_from_date');
				$to_date = $this->input->post('search_to_date');
				$data['books'] = $this->Custombook_model->show_custombook($this->userid,$search,$from_date,$to_date); 
				$this->load->pagetemplate('custom_booklist',$data);
			}
			else
			{			
				$this->load->model('Custombook_model');
				$search = $this->input->post('custom_titlesearch');
				$from_date = $this->input->post('search_from_date');
				$to_date = $this->input->post('search_to_date');
				$data['books'] = $this->Custombook_model->show_custombook($this->userid,$search,$from_date,$to_date); 
				$this->load->pagetemplate('custom_booklist',$data); 
			}
		}
    } 
	
	public function list_primarybook(){
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		 {
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Custombook_model');
			$var =  $this->Custombook_model->list_primarybook(); 
			return $var ;
		}
	}
	
	public function delete_custumbook($bokid){

	if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		 {
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->load->model('Custombook_model');
			$varid =  $this->Custombook_model->delete_custumbook($this->userid,$bokid);
			$this->Custombook_model->delete_custumchapter($this->userid,$varid);
			redirect('Custombook_library/show_custombook', 'refresh');
		}
	 
	
	
	}
	public function list_custumchapter($book_id)
    {
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$split = explode("-",$book_id);
			$custmbokid = $split[0];
			$this->load->model('Custombook_model');
			$chapList = $this->Custombook_model->list_custumchapter($custmbokid); 
	        header('Content-Type: application/x-json; charset=utf-8');
            echo(json_encode($chapList));
		}
    }
	
	
	public function addcustombook($id = 0)
	{
		if(!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			
			$this->session->set_userdata('last_url','');
			$data['userInfo'] = $this->userinfo();

			$data['primary_book'] = array(
				'name'	=> 'primary_book',
				'id'	=> 'primary_book',
				'value'	=> $this->list_primarybook(),
				'maxlength'	=> 200,
				'size'	=> 30,
				'for' => "Primary Book",
				'class' => "form-control col-sm-3",
				'selected' => ''
			);
			
			$data['cus_book_title'] = array( 
				'name'	=> 'cus_book_title',
				'id'	=> 'cus_book_title',
				'value'	=> set_value('cus_book_title'),
				'maxlength'	=> 80,
				'size'	=> 30,
				'for' => "Book Title",
				'class' => "form-control col-sm-3",
			);
				
			$data['cus_book_des'] = array( 
				'name'	=> 'cus_book_des',
				'id'	=> 'cus_book_des',
				'value'	=> set_value('cus_book_des'),
				'for' => "Description",
				'class' => "form-control col-sm-3",
				'rows' => 10,
				'cols' => 20
			);

			$data['cus_chap_all_select'] = array( 
				'name'	=> 'cus_chap_all_select',
				'id'	=> 'cus_chap_all_select',
				'value'	=> set_value('cus_chap_all_select'),
				'for' => "Selected All Chapter",
				'type' => 'checkbox'
			);
						
			$data['selected_cusbook_chap'] = array( 
				'name'	=> 'selected_cusbook_chap[]',
				'id'	=> 'selected_cusbook_chap',
				'value'	=> set_value('selected_cusbook_chap[]'),
				'for' => "Selected Book Chapter",
				'class' => "form-control col-sm-3",
				'multiple' => 'multiple',
				'maxlength'	=> 200,
				'size'  => "50",
				'selected' => array(189,191)
			);
			
			$data['cus_book_price'] = array(  
				'name'	=> 'cus_book_price',
				'id'	=> 'cus_book_price',
				'value'	=> set_value('cus_book_price'),
				'for' => "Price",
				'class' => "form-control col-sm-3",
				'maxlength'	=> 5,
				'size'  => "13",
			);
			
			$data['valid_date_from'] = array( 
				'name'	=> 'valid_date_from',
				'id'	=> 'valid_date_from',
				'value'	=> set_value('valid_date_from'),
				'for' => "valid Date From",
				'class' => "form-control datepicker",
				'maxlength'	=> 5,
				'size'  => "13",
			);

			$data['valid_date_to'] = array(
				'name'	=> 'valid_date_to',
				'id'	=> 'valid_date_to',
				'value'	=> set_value('valid_date_to'),
				'for' => "Valid Date To",
				'class' => "form-control datepicker",
				'maxlength'	=> 5,
				'size'  => "13",
			);

			$data['cus_book_img'] = array(
				'name'	=> 'cus_book_img',
				'id'	=> 'cus_book_img',
				'value'	=> set_value('cus_book_img'),
				'for' => "Book image",
				'class' => "form-control",
				'type'=>'hidden'
			);	
			
			$data['oldbook_cover_img'] = array(
				'name'	=> 'oldbook_cover_img',
				'id'	=> 'oldbook_cover_img',
				'value'	=> set_value('oldbook_cover_img'),
				'for' => "Old Book Cover Image",
				'class' => "form-control",
				'type'=>'hidden'
			);						

			$data['cus_book_close'] = array(
				'name'	=> 'cancel',
				'id'	=> 'CANCEL',
				'class' => "cancel",
				);						

			$data['cus_bookid'] = array(
				'name'	=> 'cus_bookid',
				'id'	=> 'cus_bookid',
				'value'	=> set_value('cus_bookid'),
				'for' => "Custom Book id",
				'class' => "form-control",
				'type'=>'hidden'
			);
			
			$data['thump_img'] = array(
				'value' => ''
			);
			
//			$this->form_validation->set_rules('primary_book','Primary Book','trim|required');
			$this->form_validation->set_rules('cus_book_title','Book Title','trim|required');
			$this->form_validation->set_rules('cus_book_des','Book Description','trim|required');
			$this->form_validation->set_rules('cus_book_price','Price','trim|numeric');
			$this->form_validation->set_rules('selected_cusbook_chap[]','Custom Book Chapter','trim|required');
			$this->form_validation->set_rules('valid_date_from','Valid Date From','trim|required');
			$this->form_validation->set_rules('valid_date_to','Valid Date To','trim|required');
			
			
			if($this->form_validation->run()){
				
				$primaryBook = $this->input->post('primary_book');
				$split = explode("-",$primaryBook);
				$custmbokid = $split[0];
				$custbokvid = $split[1];
				//$custhumb_image = $split[2];
				$isbn = $this->Custombook_model->get_isbn($custmbokid);
				$vol_Number = $this->Custombook_model->get_vol_number($custbokvid);
				$customBookTilte = $this->input->post('cus_book_title');
				$customBookDesc = $this->input->post('cus_book_des');
				$customBookPrice = $this->input->post('cus_book_price');
				$custmchpid = $this->input->post('selected_cusbook_chap');
				
				$validateDateFrom = $this->input->post('valid_date_from');
				$validateDateFrom = strtotime($validateDateFrom);
				$validateDateFrom = date('Y-m-d',$validateDateFrom);
				
				$validateDateTo	= $this->input->post('valid_date_to');
				$validateDateTo	= strtotime($validateDateTo);
				$validateDateTo = date('Y-m-d',$validateDateTo);
				
				$cus_book_img = $this->input->post('cus_book_img');
				$cus_oldbook_img = $this->input->post('oldbook_cover_img');
				$cus_book_img = explode("/",$cus_book_img);
				$cus_book_img = $cus_book_img[count($cus_book_img) - 1];
				if(trim($cus_book_img) == "")
					$img = $cus_oldbook_img;
				else {
					$img = $cus_book_img;
					@copy('.'.$this->config->item('temp_upload_path').$img, $this->config->item('book_path') .  $isbn ."/vol-". $vol_Number ."/cover_img/" . $img );
				}
				if($id == 0){
					$this->book_id = $this->Custombook_model->add_custumbook($this->userid,$custmbokid,$custbokvid,$customBookTilte,$customBookDesc,$validateDateFrom,$validateDateTo,$customBookPrice,$img);
	
					foreach($custmchpid as $chapid){			
						$this->Custombook_model->add_custumchapter($this->userid,$this->book_id,$custbokvid,$chapid);
					}
				}else if($id > 0){
					$this->Custombook_model->update_custombook($this->userid,$id,$custmbokid,$custbokvid, $customBookTilte,$customBookDesc,$customBookPrice,$validateDateFrom,$validateDateTo,$img);
					$this->Custombook_model->delete_custumchapter($this->userid,$id);
					
					foreach($custmchpid as $chapid){
						$this->Custombook_model->add_custumchapter($this->userid,$id,$custbokvid,$chapid);
					}					
				}
				redirect('Custombook_library/show_custombook', 'refresh');
				
			}else if(!$this->input->post('update') && $id >0){
				$this->load->model('Custombook_model');
				$cus_book_data = $this->Custombook_model->edit_custombook($id);
				$chapters = $this->Custombook_model->edit_customchapter($id);
				$data['primary_book']['selected'] = $cus_book_data->m_custmbokid .'-'. $cus_book_data->m_custbokvid;
				$data['cus_book_title']['value'] = $cus_book_data->m_custboktitle;					
				$data['cus_book_des']['value'] = $cus_book_data->m_custbokdescription;
				$data['oldbook_cover_img']['value'] = $cus_book_data->m_custbokthumb;					
				$data['selected_cusbook_chap']['selected'] = $chapters;
				$data['cus_book_price']['value'] = $cus_book_data->m_custbokprice;					
				$data['valid_date_from']['value'] = $cus_book_data->m_custbokvalidfrom; 					
				$data['valid_date_to']['value'] = $cus_book_data->m_custbokvalidto;					
				$data['cus_bookid']['value'] = $cus_book_data->m_custbokid;		

				$isbn = $this->Custombook_model->get_isbn($cus_book_data->m_custmbokid);
				$vol_Number = $this->Custombook_model->get_volnumber($cus_book_data->m_custmbokid);
				$data['thump_img']['value']= "";
				if($cus_book_data->m_custbokthumb != ""){
					$data['thump_img']['value']= base_url($this->config->item('book_path'))."/".$isbn."/vol-".$vol_Number."/"."cover_img"."/".$cus_book_data->m_custbokthumb;	
				}
			}
			$this->load->pagetemplate('custom_book_form',$data);			
			
		}
	
	}
	
}