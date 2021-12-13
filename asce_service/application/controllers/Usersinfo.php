<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Usersinfo extends REST_Controller {

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
        $this->load->model('Usersinfo_m');
        //$this->authenticate();
        $this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->helper(array('form', 'url'));
        $this->load->library('encrypt');
        $this->load->helper('html');
		//$this->load->library('form_validation');
		$this->load->library('excel_reader');
		//$this->load->library('reader');
		
        
    }
    
    
    // Requested URL is incorrect this function will displays error
    
    function index_get(){
       
	   $index = $this->response(array('error' => 'URL requested is not found'), 404);
    }
    
     // Get user response
   	function userinfo_get()
    {
       
       if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
       else
       {
        $this->load->model('Usersinfo_m');
        $data = $this->Usersinfo_m->userinfo_get();
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
             $ses = $this->Usersinfo_m->ses_get();
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
            $user = $this->Usersinfo_m->field_get();
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

	// Post user information
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