<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailsend extends CI_Controller {
	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		//$this->load->library('email');
	}
	public function index()
	{
$to = "somebody@example.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: webmaster@example.com" . "\r\n" .
"CC: somebodyelse@example.com";

echo "Asnuj".mail($to,$subject,$txt,$headers);
	}
}
?>