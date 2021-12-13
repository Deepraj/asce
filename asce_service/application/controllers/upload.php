<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$this->load->view('upload_forms', array('error' => ' ' ));
	}

	function do_upload()
	{
		$config['upload_path'] = ('./uploads/');
		$config['allowed_types'] = 'doc|xls|png|xml';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_forms', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('upload_success', $data);
			
			echo $data['upload_data']['full_path'];
			
		}
	}
}
?>