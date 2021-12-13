<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Xmlload extends CI_Controller
{
	private $book_id;
	private $vol_id;
	private $user_id;
	private $isbn;
	private $vol_no;
	private $chapter_id;
	
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
		$this->load->library('xml');
		$this->load->helper('xml');
		$this->load->model('Xmlload_model');
		$this->load->library('session');
		$this->parse_data = array();
		
	}
	
	function xmlcon(){
			$var = $this->session->userdata('filename');
            $this->isbn = $this->session->userdata('isbnno');
            $this->vol_no = $this->session->userdata('volumeno');
        	if ($this->xml->load('../uploads/xml/'.$var)) { // Relative to APPPATH, ".xml" appended
		    $this->xml->parse();
			$this->parse_data = $this->xml->get_xml_data();
			$this->user_id = $_SESSION['user_id'];
			
			$this->book_id = $this->Xmlload_model->is_isbnexits($this->isbn);
			if(	! $this->book_id )
				$this->book_id = $this->Xmlload_model->add_isbn($this->isbn,$this->user_id);
			$this->vol_id = $this->Xmlload_model->is_volumeexists($this->book_id,$this->vol_no);
			if( ! $this->vol_id )
				$this->vol_id = $this->Xmlload_model->add_volume($this->vol_no,$this->user_id,$this->book_id);
			
			$content = $this->get_xml_details();
			
			
		}
			
	}
	
	public function get_xml_details(){
	  $arr_xml = array();
	  $arrxml_return = array();
	  $k=0;
	  
	  $childNodes = $this->parse_data->getElementsByTagName('book-part');
	  
	  /*foreach ($this->parse_data as $sibling) {
    if (!is_null($sibling->attributes) 
        && $sibling->attributes->getNamedItem('id')->nodeValue == 'indent1') {
           break;
    }
//    print "\tSibling: ".$sibling->nodeValue."\n";  
	$child = $sibling->getElementsByTagName('title-group');
	$sec = $sibling->getElementsByTagName('body');
	
	foreach ($child as $chapter){
	//print_r($chapter);
	//print_r($chapter->textContent)."<br/>";
	}
	foreach ($sec as $section){
	$nodes = $section->nodeValue;
	print_r($section->getAttribute('id'));
	}
	
} */

	  foreach ($this->parse_data as $chapter){
		$childNodes = $chapter->childNodes;	
		
/*		$k=0; 
		foreach ($childNodes as $child) {
			print_r($child->getElementsByTagName('title-group'));
			echo"</br></br></br>$k";
			if($k ==1)
				print_r($child->getElementsByTagName('sec'));
			$k++;
		}
		exit;*/
		$k=0; 
		foreach ($childNodes as $child) {
	//		print_r($child);
		exit;
			if($k == 0){
				$chapter_links= $child->getElementsByTagName('title-group');
//				print_r($chapter_links);
				
				foreach($chapter_links as $d) {
					if($this->add_chapter($d)){
						echo "chapter exist !!..";
						return true;
					}
				}
			}else if($k == 1){
				$sec_links= $child->getElementsByTagName('body');
		//		print_r($sec_links);exit;
				foreach($sec_links  as $a) {
			//		print_r($a);
					echo "</br></br></br>";
					//$db_sec_id = $this->add_section($a);
				}
			}
			$k++;
		}
/*					$db_sec_id = $this->add_section($a);
					return $db_sec_id;
					$table_links= $a->getElementsByTagName('table-wrap');
					$figure_links= $a->getElementsByTagName('fig');
					foreach($table_links as $b){
						$table_data = $this->add_table($b);
						return $table_data;
					}
					foreach($figure_links as $c){
						$figure_data  = $this->add_figure($c);
						return $figure_data; 
					}
				}
			}
	}*/
	
  }
	return array($arrxml_return);
	
}
	
	public function add_chapter($chapData){
		 $chap_label = $chapData->getElementsByTagName('label')->item(0)->nodeValue;
		 $chap_title = $chapData->getElementsByTagName('title')->item(0)->nodeValue;
		 if($this->Xmlload_model->is_chapter_exist($chap_title,$this->vol_id)){
			 return true;
		 }
		 $explode = explode(" " , $chap_label);
		 $linkpage = $explode[1];
		 $chpid = $explode[1];
		 $this->chapter_id = $this->Xmlload_model->add_chapter($this->user_id,$chap_title,$chap_label,$chpid,$linkpage,$this->vol_id);	
		 return false;
	}
	
	public function add_section($secData){
		echo "section</br>";
		$sec_id = mysql_real_escape_string($secData->getAttribute('id'));
		$sec_title = mysql_real_escape_string($secData->getElementsByTagName('title')->item(0)->nodeValue);
		$sec_label = mysql_real_escape_string($secData->getElementsByTagName('label')->item(0)->nodeValue);
		$sec_para = $secData->getElementsByTagName('p')->item(0)->nodeValue;
		$sec_level = count(explode(".", $sec_label)) - 2;
		$masterId[$sec_level] = 0;
		$sec_masterId = ($sec_level == 0 ? 0: $masterId[$sec_level-1]);
		$masterId[$sec_level] = $this->Xmlload_model->add_section($this->chapter_id,$sec_title,$this->vol_id,$sec_label,$sec_level,$sec_id,$this->user_id,$sec_masterId);
	}
	
	public function add_table($tableData){
		$table_id = $tableData->getAttribute('id')."<br/>";	
		$table_para = $tableData->getElementsByTagName('p')->item(0)->nodeValue;
		$table_label = $tableData->getElementsByTagName('label')->item(0)->nodeValue;
		
		$arr_xml["id"] = $table_id;
		$arr_xml["p"] = $table_para;
		$arr_xml["label"] = $table_label;
		$arrxml_return[] = $arr_xml;
	}
	
	public function add_figure($figureData){
	
		$figure_id = $c->getAttribute('id');	
		$figure_para = $c->getElementsByTagName('p')->item(0)->nodeValue;
		$figure_label = $c->getElementsByTagName('label')->item(0)->nodeValue;
		
		 $arr_xml["id"] = $figure_id;
		 $arr_xml["p"] = $figure_para;
		 $arr_xml["label"] = $figure_label;
		 $arrxml_return[] = $arr_xml;
	}
	
	public function get_section_details(){
	  $arr_sec = array();
	  $arrsec_return = array();
	  $sec_titles = $this->parse_data->getElementsByTagName('sec');
	  $k=0;
	  
foreach ($sec_titles as $sec_title) //go to each section 1 by 1 
		{
		 $attr_sec = $sec_titles->item($k)->getAttribute('id');   //get section attribute 
		 $title = $sec_title->getElementsByTagName('title')->item(0)->nodeValue;
		 $label = $sec_title->getElementsByTagName('label')->item(0)->nodeValue;
		 $para = $sec_title->getElementsByTagName('p')->item(0)->nodeValue;
		 
		 $arr_sec["id"] = $attr_sec;
		 $arr_sec["title"] = $title;
		 $arr_sec["label"] = $label;
		 $arr_sec["p"] = $para;
		 $arrsec_return[] = $arr_sec;
		 $k++;
		}
		return $arrsec_return;
}
	
	public function get_figure_details(){
	  $arr_fig = array();
	  $arrfig_return = array();
	  $fig_titles = $this->parse_data->getElementsByTagName('fig');
	  $k=0;
	  
foreach ($fig_titles as $fig_title) //go to each section 1 by 1 
		{
		 $attr_fig = $fig_titles->item($k)->getAttribute('id');   //get section attribute 
		 $para = $fig_title->getElementsByTagName('p')->item(0)->nodeValue;
		 $label = $fig_title->getElementsByTagName('label')->item(0)->nodeValue;
		 
		 $arr_fig["id"] = $attr_fig;
		 $arr_fig["p"] = $para;
		 $arr_fig["label"] = $label;
		 $arrfig_return[] = $arr_fig;
		 $k++;
		}
		return $arrfig_return;
}
	
  public function get_chapter_details(){
	  $arr_chap = array();
	  $arr_sec = array();
	  $arrchap_return = array();
	  $arrsec_return = array();
	  $cahp_titles = $this->parse_data->getElementsByTagName('book-part');
	  //$atts = $this->parse_data->getElementsByTagName('book-body');
	
	foreach( $cahp_titles as $chap_title){
		$title = $chap_title->getElementsByTagName('title')->item(0)->nodeValue;
		$label = $chap_title->getElementsByTagName('label')->item(0)->nodeValue;
		$id = $chap_title->getAttribute('id');
		$arr_chap["id"] = $id;
		$arr_chap["title"] = $title;
		$arr_chap["lable"] = $label;
       $arrchap_return[] = $arr_chap;
	}
	return $arrchap_return;
	
	/*foreach( $atts as $att){
		 $id = $atts->getAttribute('book-part');
  		 $cnt = $atts->nodeValue;
		 $arr_sec["book-part"] = $cnt;
		 $arrsec_return[] = $arr_sec;
	}
	return $arrsec_return;*/
  }
	
	
   public function get_table_details(){
	  $arr_table = array();
	  $arrtable_return = array();
	  $table_titles = $this->parse_data->getElementsByTagName('table-wrap');
	  //$atts = $this->parse_data->getElementsByTagName('book-body');
	
	foreach( $table_titles as $table_title){
		//$title = $chap_title->getElementsByTagName('title')->item(0)->nodeValue;
		$para = $table_title->getElementsByTagName('p')->item(0)->nodeValue;
		$label = $table_title->getElementsByTagName('label')->item(0)->nodeValue;
		$id = $table_title->getAttribute('id');
		$arr_table["id"] = $id;
		$arr_table["p"] = $para;
		$arr_table["lable"] = $label;
       $arrtable_return[] = $arr_table;
	}
	return $arrtable_return;
	
  }
	

}

