<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload_process extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
	}

	function index()
	{
		$this->load->view('upload_xmlprocess', array('error' => ' ' ));
		 //redirect('Xmlload.php','xmlcon);
	}
	
	

	function do_upload()
	{
		$config['upload_path'] = ('./system/uploads/xml/');
		$config['allowed_types'] = 'doc|xls|png|xml';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_xmlprocess', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('upload_xmlsuccess', $data);
			//$isbn["isbn"] = $this->input->get_post("isbn", TRUE);
			//$bokvolno["volumeno"] = $this->input->get_post("volumeno", TRUE);
			$file_path = $data['upload_data']['full_path'];
			$file = explode("/", $file_path);
			$file_xml = explode(".", $file[7]);
		
			$this->session->set_userdata('filename',$file_xml[0]);
			//$this->session->set_userdata('isbnno',$isbn["isbn"]);
			//$this->session->set_userdata('volumeno',$bokvolno["volumeno"]);		
			redirect('Loaddata/xmlcon', 'refresh');	
		}
	}
}
?>