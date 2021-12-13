<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth','session');
		$this->load->model('Book_m');
	}

	function index($book_type='',$book_id='',$vol_id='')
	{
	
		if (!$this->tank_auth->is_logged_in() && empty($this->session->userdata("__ci_last_regenerate"))){
			redirect('/auth/login/');
		
		}else {
			if($this->session->userdata('last_url') ==''){
				$this->session->set_userdata('cus_book_id','');
				if($book_type == "PRIMARY"){
					if($this->Book_m->is_valid_book($book_id,$vol_id) ){
					    $this->session->set_userdata('book_type','PRIMARY');
						$this->session->set_userdata('vol_id',$vol_id);
						$this->session->set_userdata('book_id',$book_id);
						redirect($this->config->item('player_url')."/index.html?ver=" . APP_VERSION );
					}else{
						$this->Read_book_message[] = "not a valid book ! please check in booklibrary </br>";
						$data['result'] = $this->Read_book_message;
						$this->load->pagetemplate('readbook_message', $data);
						exit;
					}
				}else if($book_type == "COSTOM"){
					$custom_book_id = $book_id;
					$primary_book_detail = $this->Book_m->get_custom_book_details($book_id);
					if(!$primary_book_detail){
						echo "not a valid book ! please check in booklibrary";
						exit;
					}
					$book_id = $primary_book_detail->m_custmbokid;
					$vol_id = $primary_book_detail->m_custbokvid;
					if($this->Book_m->is_valid_book($book_id,$vol_id) ){
						$this->session->set_userdata('book_type','CUSTOM');
						$this->session->set_userdata('vol_id',$vol_id);
						$this->session->set_userdata('cus_book_id',$custom_book_id);
						$this->session->set_userdata('book_id',$book_id);
						
						redirect($this->config->item('player_url')."/index.html?ver=" . APP_VERSION );
					}else{
						echo "not a valid book ! please check in booklibrary";
						exit;
					}
				}
				else {
						echo "not a valid book ! please check in booklibrary";
						exit;
				}
				
			}
			else {
				redirect($this->session->userdata('last_url'), 'refresh');
				$this->session->set_userdata('last_url','');
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */