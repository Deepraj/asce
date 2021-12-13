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
class Example extends REST_Controller {

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
        $this->load->model('Book_model');
        //$this->authenticate();
        $this->load->library('tank_auth');
		$this->lang->load('tank_auth');
        $this->load->helper(array('form', 'url'));
        $this->load->library('encrypt');
        $this->load->helper('html');
		//$this->load->library('form_validation');
		
        
    }
    
    // Requested URL is incorrect this function will displays error
    
    function index_get(){
        
        $index = $this->response(array('error' => 'URL requested is not found'), 404);
    }
    
    
   function field_get()
    {
       
       if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
        {
           //redirect ('/auth/login');
         $this->response(array('error' => 'Sorry User not logged in'));
        }
       else
       {
           $this->load->model('Book_model');
        $data = $this->Book_model->field_get();
        $field = $this->response($data, 200);
        
        
        /*$field = $this->Book_model->field_get();
          // print_r($field);
          // echo $student_id = $field->row()->email;
           $my_values = array();
            foreach($field as $row)
            {
               $username = $my_values[] = $row->email;
               $token = $my_values[] = $row->token;
               $password = $my_values[] = $row->password;

            }
           //echo $encode = md5($token .$username. $password. time());
           echo $encode = $this->encrypt->encode($token .$username. $password. time());
           echo br(3);
           $decode = $this->encrypt->decode($encode);
           echo $decode;
           //echo br(3);
            
//           echo $my_vaues[0];
           
           //$field = $this->response($token, 200); 
           
           //$username = "cheneliereAdmin";
// $password = "chene126";
// $secret_key = "X*d95Cp_U8Pz@4A";
// $token = md5($secret_key .$username. $password. time());
//http://ws.cheneliere.ca/admin/login/?token=". $token ."&expiration=".time();
        */   
       }
    }
    
    function ses_get()
    {
        if(!$this->tank_auth->is_logged_in(TRUE)) //Users not logged in
        {
            //redirect ('/auth/login');
            $this->response(array('error' => 'Sorry User not logged in'), 404);
        }
        else
        {
             $ses = $this->Book_model->ses_get();
             $ses = $this->response($ses, 200); 
        }
    }

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
        //$user = $this->response($encode, 200); 
        
        
        /*if (!$this->get('id'))
        {
            $this->response(NULL, 400);
        }
        
        // $user = $this->some_model->getSomething( $this->get('id') );
        $users = [
            1 => ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
            2 => ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
            3 => ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
        ];

        $user = @$users[$this->get('id')];
*/
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

    function users_get()
    {
        // $users = $this->some_model->get_something($this->get('limit'));
        $users = array(
            array('id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'),
            array('id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'),
            3 => array('id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', 
			array('hobbies' => array('guitar', 'cycling'))),
        );

        if ($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
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
