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
//$config['mailtype'] = 'html';
//$config['charset'] = 'utf-8';
//$config['newline'] = "\r\n";

 $config['protocol'] = 'sendmail';
 $config['smtp_host'] = 'ssl://smtp.googlemail.com';
 $config['smtp_port'] = "465";
 $config['smtp_user'] = "anujmn@gmail.com";//also valid  Google Apps Accounts
 $config['smtp_pass'] = "anuj1986";
 $config['mailtype'] = 'html';
 $config['charset'] = 'iso-8859-1';
 $config['newline'] = "\r\n";
 
/* End of file email.php */
/* Location: ./application/config/email.php */