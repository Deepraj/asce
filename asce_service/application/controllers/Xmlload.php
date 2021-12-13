<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Xmlload extends CI_Controller
{
	private $book_id;
	private $vol_id;
	private $user_id;
	private $isbn;
	private $vol_no;
	private $chapter_id;
	private $masterId;
	
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
		$this->masterId = array();
		
	}
	
	function xmlcon(){
			
			$var = $this->session->userdata('filename');
			$this->isbn = $this->session->userdata('isbnno');
            $this->vol_no = $this->session->userdata('volumeno');
			$description = $this->session->userdata('description');
			$booktitle = $this->session->userdata('booktitle');
        
        	if ($this->xml->load('../uploads/xml/'.$var)) {
                $num_length = strlen((string)$this->isbn);
            if($num_length == 13) {
        
            //if(!is_dir("../asce_content/book/". $this->isbn ."/")) {
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
            mkdir("../asce_content/book/".$this->isbn ."/");
            mkdir("../asce_content/book/".$this->isbn ."/vol-".$this->vol_no."");    
            mkdir("../asce_content/book/$this->isbn/vol-".$this->vol_no."/"."commentary"."/");
            mkdir("../asce_content/book/$this->isbn/vol-".$this->vol_no."/"."pages"."/");
            mkdir("../asce_content/book/$this->isbn/vol-".$this->vol_no."/"."xml"."/");
                
                
                
            $xml_file = $this->session->userdata('filename').".xml";
			
			$playerPath = "../script/";
            
/******************************Convert XML files to HTML files***************************************/
		$xml_explode = explode("_",$xml_file);
		$dot_explode = explode(".",$xml_explode[1]);
		
		$page_panel = $dot_explode[0];
		$code = $dot_explode[0];
        $chars1 = preg_split("/[0-9]/",$code);
        $chars2 = preg_split("/[a-zA-Z]/",$code);
        $chars = array_merge($chars1,$chars2);
		
		$playerPath = "../script/";		
		$file_name = $this->session->userdata('filename');// Relative to APPPATH, ".xml" appended
		
		if(in_array("ch",$chars)){
		
		$fileext = ".xml";
		$xml= file_get_contents($playerPath."system/uploads/xml/".$file_name.$fileext);
		
			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
		$result = preg_replace($find, $replace, $xml);
		$fwrite = file_put_contents("../asce_content/book/".$this->isbn."/vol-".$this->vol_no."/xml/".$file_name.$fileext, $result);
            
		
		$explode = explode(".",$xml_file);
		$chap_name = explode("_",$explode[0]);
		$chars1 = preg_split("/[0-9]/",$chap_name[1]);
        $chars2 = preg_split("/[a-zA-Z]/",$code );
        $chars = array_merge($chars1,$chars2);
		
			$final_html = $chars[0].$chars[5].".html";	
			$result = exec('java -jar F:\xampp\htdocs\ASCE\asce_content\tmp\saxon9.jar -s:"../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/xml/' . $file_name.$fileext . '" -o:"../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
		}   
        
        if(in_array("chc",$chars)){
		
		$fileext = ".xml";
		$xml= file_get_contents($playerPath."system/uploads/xml/".$file_name.$fileext);
		
			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
		$result = preg_replace($find, $replace, $xml);
		$fwrite = file_put_contents("../asce_content/book/'.$this->isbn.'/'.$this->vol_no.'/xml/".$file_name.$fileext, $result);
		
		$explode = explode(".",$xml_file);
		$chap_name = explode("_",$explode[0]);
		$chars1 = preg_split("/[0-9]/",$chap_name[1]);
        $chars2 = preg_split("/[a-zA-Z]/",$code );
        $chars = array_merge($chars1,$chars2);
		
			$final_html = $chars[0].$chars[6].".html";	
			$result = exec('java -jar F:\xampp\htdocs\ASCE\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $file_name.$fileext . '" -o:"../asce_content/book/'.$this->isbn.'/'.$this->vol_no.'/commentary/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
		}
		
		if(in_array("ap",$chars)){
			$fileext = ".xml";
		$xml= file_get_contents($playerPath."system/uploads/xml/".$file_name.$fileext);
		
			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
		$result = preg_replace($find, $replace, $xml);
		$fwrite = file_put_contents("../asce_content/book/'.$this->isbn.'/'.$this->vol_no.'/xml/".$file_name.$fileext, $result);
		
		$explode = explode(".",$xml_file);
		$chap_name = explode("_",$explode[0]);
		$chars1 = preg_split("/[0-9]/",$chap_name[1]);
        $chars2 = preg_split("/[a-zA-Z]/",$code );
        $chars = array_merge($chars1,$chars2);
		
			$final_html = $chars[0].$chars[5].".html";	
			$result = exec('java -jar F:\xampp\htdocs\ASCE\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $file_name.$fileext . '" -o:"../asce_content/book/'.$this->isbn.'/'.$this->vol_no.'/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
			
		}
                
		if(in_array("apc",$chars)){
			$fileext = ".xml";
		$xml= file_get_contents($playerPath."system/uploads/xml/".$file_name.$fileext);
		
			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
		$result = preg_replace($find, $replace, $xml);
		$fwrite = file_put_contents("../asce_content/book/'.$this->isbn.'/'.$this->vol_no.'/xml/".$file_name.$fileext, $result);
		
		$explode = explode(".",$xml_file);
		$chap_name = explode("_",$explode[0]);
		$chars1 = preg_split("/[0-9]/",$chap_name[1]);
        $chars2 = preg_split("/[a-zA-Z]/",$code );
        $chars = array_merge($chars1,$chars2);
		
			$final_html = $chars[0].$chars[6].".html";	
			$result = exec('java -jar F:\xampp\htdocs\ASCE\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $file_name.$fileext . '" -o:"../asce_content/book/'.$this->isbn.'/'.$this->vol_no.'/commentary/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
			
			
		}
       
           // }
                
            //else{
            //echo "".$this->isbn." Exist";
            // }
            }
            else{
            echo "Please enter 13 Digit ISBN number";
            }
            
			$file_name = $this->session->userdata('filename');// Relative to APPPATH, ".xml" appended
            $this->xml->parse();
			$this->parse_data = $this->xml->get_xml_data();
			$this->user_id = $_SESSION['user_id'];
			$description = $this->session->userdata('description');
			$booktitle = $this->session->userdata('booktitle');
			$booktitledes = $this->session->userdata('booktitledes');
			$authors = $this->session->userdata('authors');
			$price = $this->session->userdata('price');
			
			
			$this->book_id = $this->Xmlload_model->is_isbnexits($this->isbn);
			if(	! $this->book_id )
				$this->book_id = $this->Xmlload_model->add_isbn($this->isbn,$this->user_id,$description,$booktitle,$booktitledes,$authors,$price);
			$this->vol_id = $this->Xmlload_model->is_volumeexists($this->book_id,$this->vol_no);
			if( ! $this->vol_id )
				$this->vol_id = $this->Xmlload_model->add_volume($this->vol_no,$this->user_id,$this->book_id);
			
			$content = $this->get_xml_details($this->parse_data,$file_name);	
			$data['userInfo'] = $this->session->userdata('userInfo' );
			if(!count($data['userInfo']))
				redirect('admin/', 'refresh');

			$data['error'] =  '';			
			$this->load->pagetemplate('uploadbooks_sucess',$data);
		}
		
			$xml_file = $this->session->userdata('filename').".xml";
			
			$playerPath = "../ASCE_services/";

/******************************Convert XML files to HTML files***************************************/
		$xml_explode = explode("_",$xml_file);
		$dot_explode = explode(".",$xml_explode[1]);
		
		$page_panel = $dot_explode[0];
		$code = $dot_explode[0];
        $chars1 = preg_split("/[0-9]/",$code);
        $chars2 = preg_split("/[a-zA-Z]/",$code);
        $chars = array_merge($chars1,$chars2);
		
		$playerPath = "../ASCE_services/";		
		
		
		
/******************************Convert XML files to HTML files End***************************************/			
	}

	
	
	public function get_xml_details($data,$file_name){
	 // Get front matter details	
   	 $frontmatter_details = $this->parse_data->getElementsByTagName('body');
	 
	 foreach($frontmatter_details as $fm) {
	  $db_front = $this->add_frontmatter($fm);
	 }
	 //Get chapter detils
	 $chapter_details = $this->parse_data->getElementsByTagName('book-part');

		foreach($chapter_details as $c) {
			if($this->add_chapter($c,$file_name)){
			echo "chapter exist !!..";
			return false;
			}
	 //Get Section detils
	 $section_details = $this->parse_data->getElementsByTagName('sec');
	 	foreach($section_details as $s) {
			$db_sec_id = $this->add_section($s);
		}
	//Get Table detils	
	 $table_details = $this->parse_data->getElementsByTagName('table-wrap');
	 
		foreach($table_details as $t) {
		   	$db_table_id = $this->add_table($t);
		}
	 //Get figure detils	
	 $figure_details = $this->parse_data->getElementsByTagName('fig');
	 	
		foreach($figure_details as $f) {
		   	$db_fig_id = $this->add_figure($f);
		}	
		
		foreach($chapter_details as $chcontent) {
			$db_chc_id = $this->add_chcontent($chcontent);
		}
		foreach($section_details as $seccontent) {
			$db_chc_id = $this->add_seccontent($seccontent);
		}
	}
}

	public function add_chapter($chapData,$file_name){
		
		 $chap_label = $chapData->getElementsByTagName('label')->item(0)->nodeValue;
		 $chap_title = $chapData->getElementsByTagName('title')->item(0)->nodeValue;
		 $chaplabel_id = $chapData->getAttribute('id');
		 
		 $explode = explode(" " , $chap_label);
		 $linkpage = $explode[1];
         $chap_name = explode("_",$file_name);
		 
		 $chars1 = preg_split("/[0-9]/",$chap_name[1] );
		 $chars2 = preg_split("/[a-zA-Z]/",$chap_name[1] );
		 $chars = array_merge($chars1,$chars2);
		  
		 $explode = explode(" " , $chap_label);
		 $linkpage = $explode[1];
		 $str_plabel = str_replace("s","",$chaplabel_id);
		 $str_clabel = str_replace("sc","",$chaplabel_id);
		 $str_linkpage = str_replace("C","",$linkpage);
		 		
		 $chpid = $explode[1];
		 $pages = "PAGES";
		 $commentary = "COMMENTARY";
		
		 if($chars[0] == "ch"){
		 	$panel_type = $pages;
		 }
        if($chars[0] == "chc"){
		 	$panel_type = $commentary;
		 }
         
         if($chars[0] == "ap"){
            $panel_type = $pages; 
         }
         if($chars[0] == "apc"){
            $panel_type = $commentary; 
         }
        
		 
		  if($this->Xmlload_model->is_chapter_exist($chap_title,$panel_type,$this->vol_id)){
			 return true;
		 }
		 $chap_name = explode("_",$file_name);
		 
		 $chars1 = preg_split("/[0-9]/",$chap_name[1] );
		 $chars2 = preg_split("/[a-zA-Z]/",$chap_name[1] );
		 $chars = array_merge($chars1,$chars2);
        
		 if(in_array("ch",$chars)){
            $panel_type = $pages;
			$str_linkpage = $chars[3];
			$file = explode("_",$file_name);
			$filename = $file[1];
			$str = $chars[0].$chars[5];
            $this->chapter_id = $this->Xmlload_model->add_chapter($this->user_id,$chap_title,$chap_label,$chpid,$chaplabel_id,$str_linkpage,$this->vol_id,$panel_type,$str);
			return false;
		 }
		 
		 if(in_array("chc",$chars)){
		 	
			$str_linkpage = $chars[4];
			$file = explode("_",$file_name);
			$filename = $file[1];
			$str = $chars[0].$chars[6];
			$this->chapter_id = $this->Xmlload_model->add_chapter($this->user_id,$chap_title,$chap_label,$chpid,$chaplabel_id,$str_linkpage,$this->vol_id,$panel_type,$str);
			return false;
		 }
		 
		 if(in_array("ap",$chars)){
			
			$str_linkpage = $chars[0].$chars[5];
			$file = explode("_",$file_name);
			$filename = $file[1];
			$str = $chars[0].$chars[5];
			$this->chapter_id = $this->Xmlload_model->add_chapter($this->user_id,$chap_title,$chap_label,$chpid,$chaplabel_id,$str_linkpage,$this->vol_id,$panel_type,$str);
			return false;
		 }
		 
		 if(in_array("apc",$chars)){
		 	
			$str_linkpage = $chars[0].$chars[6];
			$file = explode("_",$file_name);
			$filename = $file[1];
			$str = $chars[0].$chars[6];
			$this->chapter_id = $this->Xmlload_model->add_chapter($this->user_id,$chap_title,$chap_label,$chpid,$chaplabel_id,$str_linkpage,$this->vol_id,$panel_type,$str);
			return false;
		 }
	}
	
	public function add_frontmatter($fmData){
		$fm_para = $fmData->getElementsByTagName('p')->item(0)->nodeValue;
		$panel_type = "PAGES";
		$fm_label = "Front Matter";
		$type = "Chapter";
		$fm_id = "f1";
		$fm_data = $this->Xmlload_model->add_fm($this->chapter_id,$this->vol_id,$fm_label,$fm_id,$this->user_id,$fm_para,$type,$panel_type);
		return false;
	}
	
	public function add_section($secData){
		$sec_id = $secData->getAttribute('id');
		$sec_title = $secData->getElementsByTagName('title')->item(0)->nodeValue;
		$sec_label = $secData->getElementsByTagName('label')->item(0)->nodeValue;
		$sec_para = $secData->getElementsByTagName('p')->item(0)->nodeValue;
		$sec_level = count(explode(".", $sec_label)) - 2;
		$this->masterId[$sec_level] = 0;
		$sec_masterId = ($sec_level == 0 ? 0: $this->masterId[$sec_level-1]);
		$this->masterId[$sec_level] = $this->Xmlload_model->add_section($this->chapter_id,$sec_title,$this->vol_id,$sec_label,$sec_level,$sec_id,$this->user_id,$sec_masterId);
		return false;
	}
	
	public function add_table($tableData){
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$table_id = $tableData->getAttribute('id');	
		$table_label = $tableData->getElementsByTagName('label')->item(0)->nodeValue;
		$table_para = $tableData->getElementsByTagName('p')->item(0)->nodeValue;
		$type = "Table";
		$pages = "PAGES";
		$commentry = "COMMENTARY";
		 $code = $table_id;
		 $chars1 = preg_split("/[0-9]/",$code );
		 $chars2 = preg_split("/[a-zA-Z]/",$code );
		 $chars = array_merge($chars1,$chars2);
		 
		if(in_array("tc",$chars)){
		$panel_type = $commentry;
		$table_data = $this->Xmlload_model->add_table($this->chapter_id,$this->vol_id,$table_label,$table_id,$this->user_id,$table_para,$type,$panel_type);
		return false;
		}
		if(in_array("t",$chars)){
		$panel_type = $pages;
		$table_data = $this->Xmlload_model->add_table($this->chapter_id,$this->vol_id,$table_label,$table_id,$this->user_id,$table_para,$type,$panel_type);
		return false;
		}
		
		/*$str_table = str_replace("tc","",$table_id);
		if($table_id == "tc".$str_table){
			$panel_type = $commentry;
		}
		else{
			$panel_type = $pages;
		}*/
		
	}
	
	public function add_figure($figureData){
		$figure_id = $figureData->getAttribute('id');	
		$figure_para = $figureData->getElementsByTagName('p')->item(0)->nodeValue;
		$figure_label = $figureData->getElementsByTagName('label')->item(0)->nodeValue;
		$type = "Figure";
		$pages = "PAGES";
		$commentry = "COMMENTARY";
		$str_fig = str_replace("fc","",$figure_id);
		if($figure_id == "fc".$str_fig){
			$panel_type = $commentry;
		}
		else{
			$panel_type = $pages;
		}
		$figure_data = $this->Xmlload_model->add_figure($this->chapter_id,$this->vol_id,$figure_label,$figure_id,$this->user_id,$figure_para,$type,$panel_type);
		return false;
	}
	
	public function add_chcontent($chapchData){
		
		 $chap_label = $chapchData->getElementsByTagName('label')->item(0)->nodeValue;
		 $chap_title = $chapchData->getElementsByTagName('title')->item(0)->nodeValue;
		 
		 $explode = explode(" " , $chap_label);
		 $linkpage = $explode[1];
		 $chpid = $explode[1];
		 $type = "Chapter";
		 $pages = "PAGES";
		 $commentry = "COMMENTARY";
		 if($chpid == "C".$chpid){
		 	$panel_type = $commentry;
		 }
		 else{
		 	$panel_type = $pages;
		 }
		 
		 $chcontent_data = $this->Xmlload_model->add_chcontent($this->chapter_id,$chap_title,$this->vol_id,$chap_label,$chpid,$this->user_id,$type,$panel_type);
		 return false;
	}
	
	public function add_seccontent($secchData){
		$secch_id = $secchData->getAttribute('id');
		$secch_title = $secchData->getElementsByTagName('title')->item(0)->nodeValue;
		$secch_label = $secchData->getElementsByTagName('label')->item(0)->nodeValue;
		$secch_para = $secchData->getElementsByTagName('p')->item(0)->nodeValue;
		$type = "Section";
		$str_commentry = str_replace("C","",$secch_label);
		$pages = "PAGES";
		$commentary = "COMMENTARY";
		if($secch_label == "C".$str_commentry){
			$panelch_type = $commentary;
		}
		else{
			$panelch_type = $pages;
		}
		
		$seccontent = $this->Xmlload_model->add_seccontent($this->chapter_id,$secch_title,$this->vol_id,$secch_label,$secch_id,$this->user_id,$secch_para,$type,$panelch_type);
		return false;
	}
	
	

}

