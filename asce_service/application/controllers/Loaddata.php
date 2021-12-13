<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Loaddata extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		//$this->load->library('xmlrpc');
		//$this->load->library('xmlrpcs');
		$this->load->library('xml_process');
		$this->load->helper('xml');
		$this->load->model('Loaddata_model');
		$this->load->library('session');
		
	}
	
	function xmlcon(){
			$var = $this->session->userdata('filename');
           // $isbn = $this->session->userdata('isbnno');
           // $bokvolno = $this->session->userdata('volumeno');
        	if ($this->xml_process->load('../uploads/xml/'.$var)) { // Relative to APPPATH, ".xml" appended
			$this->xml_process->parse();
			$table_details = $this->xml_process->get_table_details();
			//$this->Loaddata_model->get_table_details($table_details);
			$figure_details = $this->xml_process->get_figure_details();
			
			$section_details = $this->xml_process->get_section_details();
			
			$chapter_details = $this->xml_process->get_chapter_details();
			
			//$fm_details = $this->xml_process->get_fm_details();
			
			$this->Loaddata_model->get_xml_details($table_details,$figure_details,$section_details,$chapter_details);
		}
			
	}
	
	

}

