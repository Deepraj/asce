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
class admin extends MY_Controller {
	
	private $userid;
	
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->database();
		$this->load->library(array('session','tank_auth'));
		$this->lang->load('tank_auth');
        $this->load->helper(array('form', 'url'));
		$this->userid = $this->session->userdata('user_id');
	
    }
   
    public function index()
    {
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->session->set_userdata('last_url','');
			$this->session->set_userdata('userInfo',$this->userinfo());
			$data['userInfo'] = $this->session->userdata('userInfo' );
	        $this->load->pagetemplate('home',$data); 
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
}
