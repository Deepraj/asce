<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
           /*$config['protocol'] = 'gsmtp';
			$config['smtp_host'] = 'ssl://smtp.googlemail.com';
			$config['mail_path'] = 'ssl://smtp.googlemail.com';
			$config['smtp_port'] = '465';
			$config['smtp_user'] = 'anujmn@gmail.com';
			$config['smtp_pass'] = 'ckelryesingszajo';
		    $config['mailtype'] = 'html';
		    $config['charset'] 	= 'iso-8859-1';
			$config['newline'] 	= "\r\n0";*/
      
    		$config['protocol'] = 'smtp';
		    //$config['smtp_host'] = '107.21.37.71';
			$config['smtp_host'] = '0.0.0.0';
			$config['smtp_port'] = 25;
			$config['smtp_user'] = '';
			$config['smtp_pass'] = '';
		    $config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
		   // $config['charset'] = 'iso-8859-1';
		    $config['newline'] = "\r\n";

/* End of file email.php */
/* Location: ./application/config/email.php */
