<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailtest extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->library('email');
	}
	public function index()
	{
		//echo "Anuj";
		//die;
		$this->load->library ( 'email' );
		$this->email->set_newline ( "\r\n" );
		$address='sweanujdubey@gmail.com';
		//$this->email->clear();
        $this->email->from('anuj.dubey@adi-mps.com');
		 $this->email->to($address);
        $this->email->subject('Here is your info ');
        $this->email->message('Hi Here is the info you requested.');
        //$this->email->send();
	   //echo "dsfsf"; die;
	    	 if($this->email->send())
    {
        echo "Mail send successfully!";
       // echo $to;
    }
    else
    {
        show_error($this->email->print_debugger());
    }
	}
}
