<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';
//require APPPATH . '/libraries/Excel_reader.php';

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
class Excelreader extends REST_Controller {

    function __construct()
    {
		
		parent::__construct();
		$this->load->library('excel_reader');
	}
	
	 function index_get(){
       
	   $index = $this->response(array('error' => 'URL requested is not found'), 404);
    }
	
	function Excelreader_get(){
	
	// Read the spreadsheet via a relative path to the document
	// for example $this->excel_reader->read('./uploads/file.xls');
	$data = array();
	

$this->data_file = "./uploads/localization_sample.xls"; //The XLS file and folder
 
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

$arr[language] = $language;//French teacher
$arr_enus[language] = "en-us"; //en-us teacher

for($p=2; $p<=$this->data_array['numRows']; $p++){
	
	$module = $this->data_array['cells'][$p][1];
	$type = $this->data_array['cells'][$p][2];
	$name = $this->data_array['cells'][$p][3];
	$attribute = $this->data_array['cells'][$p][4];
	$french = $this->data_array['cells'][$p][5];
	$english = $this->data_array['cells'][$p][6];
	
	if($module && $type && $name && $attribute && $french){
		$arr[$module][$type][$name][$attribute][$french] = $french;
		
	}
	
	if($module && $type && $name && $attribute && $english){
		$arr_enus[$module][$type][$name][$attribute][$english] = $english;
		
	}
}
	//$lang = array2json($arr);
	//$lang_enus = array2json($arr_enus);

	$langfile = "Boilerplate_".$extension.".js";
	$langfile_enus = "Boilerplate_en-us.js";


	$currentDate = date("Y_m_d_H_i_s");
	$newlangfile = $currentDate."_Boilerplate_".$extension.".js";
	$newlangfile_enus = $currentDate."_Boilerplate_en-us.js";
	
	rename("./local/".$langfile, "./local/".$newlangfile);
	rename("./local/".$langfile_enus, "./local/".$newlangfile);
	
	file_put_contents("./local/".$langfile, "\xEF\xBB\xBF".  "var localizedStrings=".$lang);
	file_put_contents("./local/".$langfile_enus, "\xEF\xBB\xBF".  "var localizedStrings=".$lang_enus);
		echo "Successfully completed";
		
 }

$chapandsec = $this->response($arr_enus, 200);


//var_dump($this->data_array);

	
	//$this->excel_reader->read('/uploads/localization_apr30.xls');
	
	//$this->excel_reader->dump($row_numbers=false,$col_letters=false,$sheet=0,$table_class='excel');
	
	//$chapandsec = $this->response($this->data_array, 200);
	
	// Get the contents of the first worksheet
	
	}
	
}