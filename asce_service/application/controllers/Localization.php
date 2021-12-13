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
class Localization extends CI_Controller {

    function __construct()
    {
		
		parent::__construct();
		$this->load->library('excel_reader');
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
        $this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		
	}
	
	
	function index(){
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->session->set_userdata('last_url','');
			$data['userInfo'] = $this->session->userdata('userInfo' );
			if(!count($data['userInfo']))
				redirect('admin/', 'refresh');

			$data['error'] =  '';
			$this->load->pagetemplate('upload_localization',$data);			
		}
	}
	function do_upload()
	{
		
		$config['upload_path'] = ('./system/uploads/local/');
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('upload_xml', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$isbn["isbn"] = $this->input->get_post("isbn", TRUE);
			$bokvolno["volumeno"] = $this->input->get_post("volumeno", TRUE);
			$file_path = $data['upload_data']['full_path'];
			$this->Localization_get($file_path);
			$data['userInfo'] = $this->session->userdata('userInfo' );
			$data['error'] = $this->upload->display_errors();			
			$this->load->pagetemplate('localization_sucess',$data);			
		}
	}
		
	function Localization_get($dataPath){
			
		// Read the spreadsheet via a relative path to the document
		// for example $this->excel_reader->read('./uploads/file.xls');
		$data = array();
			
							
		//$this->data_file = "../../../asce_production/localization/uploads/localization_sample.xls"; //The XLS file and folder
//		$this->data_file = "./uploads/localization_sample.xls"; //The XLS file and folder
		$this->data_file = $dataPath;
		 
		 if($this->data_file){
		//$CI->spreadsheet_excel_reader->setOutputEncoding('CP1251'); //I've added this one into the library itself.
		
		$this->excel_reader->read($this->data_file); //Start reading the XLS file
		
		$this->data_array = $this->excel_reader->sheets[0]; //This should return my XLS but only returns NULL
		
		
		$locale = $this->data_array['cells'][1][5]; //French_fr-ca
		$locale_en_us = $this->data_array['cells'][1][6]; //English-en-us
		
		$arr = explode('_',$locale);
		$language = $arr[0];
		$extension = $arr[1];
		
		$arr = array();
		$arr_enus = array();
		
		$arr['language'] = $language;//French teacher
		$arr_enus['language'] = "en-us"; //en-us teacher
		
		for($p=2; $p<=$this->data_array['numRows']; $p++){
			
			$module = $this->data_array['cells'][$p][1];
			$type = $this->data_array['cells'][$p][2];
			$name = $this->data_array['cells'][$p][3];
			$attribute = $this->data_array['cells'][$p][4];
			$french = $this->data_array['cells'][$p][5];
			$english = $this->data_array['cells'][$p][6];
			
			if($module && $type && $name && $attribute && $french){
				$arr[$module][$type][$name][$attribute] = $french;
				
			}
			
			if($module && $type && $name && $attribute && $english){
				$arr_enus[$module][$type][$name][$attribute] = $english;
				
			}
		}
		//$chapandsec = $this->response($arr);
		
			//$lang = array2json($arr);
			//$lang_enus = array2json($arr_enus);
			
			$lang = json_encode($arr);
			$lang_enus = json_encode($arr_enus);
		
			$langfile = "Boilerplate_".$extension.".js";
			$langfile_enus = "Boilerplate_en-us.js";
		
		
			$currentDate = date("Y_m_d_H_i_s");
			$newlangfile = $currentDate."_Boilerplate_".$extension.".js";
			$newlangfile_enus = $currentDate."_Boilerplate_en-us.js";
			$playerPath = "../book_reader/";
			
			@rename($playerPath."/local/".$langfile, $playerPath."/local/".$newlangfile);
			@rename($playerPath."/local/".$langfile_enus, $playerPath."/local/".$newlangfile_enus);
			
			@file_put_contents($playerPath."/local/".$langfile, "\xEF\xBB\xBF".  "var localizedStrings=".$lang);
			@file_put_contents($playerPath."/local/".$langfile_enus, "\xEF\xBB\xBF".  "var localizedStrings=".$lang_enus);
				//echo "Successfully completed";
				
		 }
			
	}
	
}