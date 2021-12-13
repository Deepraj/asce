<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload_xmlfile extends CI_Controller {

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

	function index()
	{
		if (!$this->tank_auth->is_logged_in(TRUE)) // Users not logged in
		{
			$this->session->set_userdata('last_url',$this->uri->segment(1));
			redirect('auth/', 'refresh');
		}else{
			$this->session->set_userdata('last_url','');
			$data['userInfo'] = $this->session->userdata('userInfo' );
			if(!count($data['userInfo']))
				redirect('admin/', 'refresh');
			
			$data['error']='';	
			$this->load->pagetemplate('upload_xml',$data);			
		}
		 //redirect('Xmlload.php','xmlcon);
	}
	
	

	function do_upload()
	{
		 if (isset($_FILES['userfile'])) {
    
			$name_array = array();
			$count = count($_FILES['userfile']['size']);
			foreach($_FILES as $key=>$value)
			for($s=0; $s<=$count-1; $s++) {
			$_FILES['userfile']['name']=$value['name'][$s];
			$_FILES['userfile']['type']    = $value['type'][$s];
			$_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
			$_FILES['userfile']['error']       = $value['error'][$s];
			$_FILES['userfile']['size']    = $value['size'][$s];  
			$config['upload_path'] = './system/uploads/xml/';
			$config['allowed_types'] = 'gif|jpg|png|xml';
			$config['max_size']	= '1000';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$this->load->library('upload', $config);
			$this->upload->do_upload();
			$data = $this->upload->data();
			$name_array[] = $data['file_name'];
    
			}
	$names= implode(',', $name_array);
/*	$this->load->database();
$db_data = array('id'=> NULL,
'name'=> $names);
$this->db->insert('testtable',$db_data);
*/	
$xmlfile = explode(',', $names);



		

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->pagetemplate('upload_xmlsuccess', $error);
		}
		else
		{
			
		    
			foreach($xmlfile as $key=>$value){
				
			$data = array('upload_data' => $this->upload->data());
			$data['userInfo'] = $this->session->userdata('userInfo' );
			if(!count($data['userInfo']))
				redirect('admin/', 'refresh');			
			$this->load->pagetemplate('upload_xmlsuccess', $data);
			$isbn["isbn"] = $this->input->get_post("isbn", TRUE);
			$bokvolno["volumeno"] = $this->input->get_post("volumeno", TRUE);
			$description["description"] = $this->input->get_post("description", TRUE);
			$booktitle["booktitle"] = $this->input->get_post("booktitle", TRUE);
			$booktitledes["booktitledes"] = $this->input->get_post("booktitledes", TRUE);
			$authors["authors"] = $this->input->get_post("authors", TRUE);
			$price["price"] = $this->input->get_post("price", TRUE);
			$file_path = $data['upload_data']['full_path'];
			$file = explode("/", $file_path);
			$file_xml = explode(".", $file[count($file)-1]);
			$this->session->set_userdata('filename',$file_xml[0]);
			$this->session->set_userdata('isbnno',$isbn["isbn"]);
			
			$this->session->set_userdata('volumeno',$bokvolno["volumeno"]);
			$this->session->set_userdata('description',$description["description"]);
			$this->session->set_userdata('booktitle',$booktitle["booktitle"]);
			$this->session->set_userdata('booktitledes',$booktitledes["booktitledes"]);
			$this->session->set_userdata('authors',$authors["authors"]);
			$this->session->set_userdata('price',$price["price"]);	
			//redirect('Xmlload/xmlcon', 'refresh');
			
			if ($config['upload_path'].$value) {
				
				$num_length = strlen((string)$isbn["isbn"]);
            if($num_length == 13) {
        
            //if(!is_dir("../asce_content/book/". $this->isbn ."/")) {
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
            mkdir("../asce_content/book/".$isbn["isbn"] ."/");
            mkdir("../asce_content/book/".$isbn["isbn"] ."/vol-".$bokvolno["volumeno"]."");    
            mkdir("../asce_content/book/".$isbn["isbn"]."/vol-".$bokvolno["volumeno"]."/"."commentary"."/");
            mkdir("../asce_content/book/".$isbn["isbn"]."/vol-".$bokvolno["volumeno"]."/"."pages"."/");
            mkdir("../asce_content/book/".$isbn["isbn"]."/vol-".$bokvolno["volumeno"]."/"."xml"."/");
         
         //   $xml_file = $this->session->userdata('filename').".xml";
			
			$playerPath = "../ASCE_services/";
            
/******************************Convert XML files to HTML files***************************************/
		$xml_explode = explode("_",$value);
		$dot_explode = explode(".",$xml_explode[1]);
		
		$page_panel = $dot_explode[0];
		$code = $dot_explode[0];
        $chars1 = preg_split("/[0-9]/",$code);
        $chars2 = preg_split("/[a-zA-Z]/",$code);
        $chars = array_merge($chars1,$chars2);
		
		$playerPath = "../ASCE_services/";		
		//$file_name = $dot_explode;// Relative to APPPATH, ".xml" appended
		//print_r($file_name);
		//exit;
		
		if(in_array("ch",$chars)){
		
		$fileext = ".xml";
		$xml= file_get_contents($playerPath."system/uploads/xml/".$value);
		
			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
		$result = preg_replace($find, $replace, $xml);
		$fwrite = file_put_contents("../asce_content/book/".$isbn["isbn"]."/vol-".$bokvolno["volumeno"]."/xml/".$value, $result);
            
		
		$explode = explode(".",$xml_file);
		$chap_name = explode("_",$explode[0]);
		$chars1 = preg_split("/[0-9]/",$chap_name[1]);
        $chars2 = preg_split("/[a-zA-Z]/",$code );
        $chars = array_merge($chars1,$chars2);
		
			$final_html = $chars[0].$chars[5].".html";	
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/'.$this->isbn.'/vol-'.$this->vol_no.'/xml/' . $value . '" -o:"../asce_content/book/'.$isbn["isbn"].'/vol-'.$bokvolno["volumeno"].'/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
		}   
        
        if(in_array("chc",$chars)){
		
		$fileext = ".xml";
		$xml= file_get_contents($playerPath."system/uploads/xml/".$value);
		
			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
		$result = preg_replace($find, $replace, $xml);
		$fwrite = file_put_contents("../asce_content/book/".$isbn["isbn"]."/vol-".$bokvolno["volumeno"]."/xml/".$value, $result);
		
		$explode = explode(".",$xml_file);
		$chap_name = explode("_",$explode[0]);
		$chars1 = preg_split("/[0-9]/",$chap_name[1]);
        $chars2 = preg_split("/[a-zA-Z]/",$code );
        $chars = array_merge($chars1,$chars2);
		
			$final_html = $chars[0].$chars[6].".html";	
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $value . '" -o:"../asce_content/book/'.$isbn["isbn"].'/'.$bokvolno["volumeno"].'/commentary/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
		}
		
		if(in_array("ap",$chars)){
			$fileext = ".xml";
		$xml= file_get_contents($playerPath."system/uploads/xml/".$value);
		
			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
		$result = preg_replace($find, $replace, $xml);
		$fwrite = file_put_contents("../asce_content/book/".$isbn["isbn"]."/vol-".$bokvolno["volumeno"]."/xml/".$value, $result);
		
		$explode = explode(".",$xml_file);
		$chap_name = explode("_",$explode[0]);
		$chars1 = preg_split("/[0-9]/",$chap_name[1]);
        $chars2 = preg_split("/[a-zA-Z]/",$code );
        $chars = array_merge($chars1,$chars2);
		
			$final_html = $chars[0].$chars[5].".html";	
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $value . '" -o:"../asce_content/book/'.$isbn["isbn"].'/'.$bokvolno["volumeno"].'/pages/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
			
		}
                
		if(in_array("apc",$chars)){
			$fileext = ".xml";
		$xml= file_get_contents($playerPath."system/uploads/xml/".$value);
		
			$find = array('/<!DOCTYPE [^>]+>/', "/<graphic([^>]*)" . 
			"xlink:href=\"([^\"]*).eps\"/", "/<collection-id ([^>]*)>(.*?)<\/collection-id>/", "/<book-id ([^>]*)>(.*?)<\/book-id>/", "/<book-title>(.*?)<\/book-title>/", "/<day>(.*?)<\/day>/","/<month>(.*?)<\/month>/", "/<year>(.*?)<\/year>/", "/<isbn ([^>]*)>(.*?)<\/isbn>/", "/<publisher-name>(.*?)<\/publisher-name>/", "/<publisher-loc>(.*?)<\/publisher-loc>/", "/<copyright-statement>(.*?)<\/copyright-statement>/", "/<copyright-year>(.*?)<\/copyright-year>/", "/<edition>(.*?)<\/edition>/", "/<collab>ASCE<\/collab>/", "/<book-part-id ([^>]*)>(.*?)<\/book-part-id>/", "/<fpage>(.*?)<\/fpage>/", "/<lpage>(.*?)<\/lpage>/", '/<sec disp-level="0" (.*?)>/');
			
			
			
			$replace = array('<!--<!DOCTYPE book PUBLIC \"-//NLM//DTD BITS Book Interchange DTD with OASIS and XHTML Tables v1.0 20131225//EN\" \"BITS-book-oasis1.dtd\">-->', "<graphic\${1} xlink:href=\"\${2}.jpg\"", "<!--<collection-id \${1}>\${2}<\/collection-id>-->", "<!--<book-id \${1})>\${2}<\/book-id>-->", "<!--<book-title>\${1}<\/book-title>-->", "<!--<day>\${1}<\/day>-->", "<!--<month>\${1}<\/month>-->", "<!--<year>\${1}<\/year>-->", "<!--<isbn \${1})>\${2}<\/isbn>-->", "<!--<publisher-name>\${1}<\/publisher-name>-->", "<!--<publisher-loc>\${1}<\/publisher-loc>-->", "<!--<copyright-statement>\${1}<\/copyright-statement>-->", "<!--<copyright-year>\${1}<\/copyright-year>-->", "<!--<edition>\${1}<\/edition>-->", "<!--<collab>ASCE<\/collab>-->", "<!--<book-part-id \${1})>\${2}<\/book-part-id>-->", "<!--<fpage>\${1}<\/fpage>-->", "<!--<lpage>\${1}<\/lpage>-->", '<sec disp-level="0">');
			
			// "<sec id='\${2}'>", "<xref ref-type='sec' rid='\${2}'>"
			
		$result = preg_replace($find, $replace, $xml);
		$fwrite = file_put_contents("../asce_content/book/".$isbn["isbn"]."/vol-".$bokvolno["volumeno"]."/xml/".$value, $result);
		
		$explode = explode(".",$xml_file);
		$chap_name = explode("_",$explode[0]);
		$chars1 = preg_split("/[0-9]/",$chap_name[1]);
        $chars2 = preg_split("/[a-zA-Z]/",$code );
        $chars = array_merge($chars1,$chars2);
		
			$final_html = $chars[0].$chars[6].".html";	
			$result = exec('java -jar D:\xampp\htdocs\asce_content\tmp\saxon9.jar -s:"../asce_content/book/9780784412916/vol-1/xml/' . $value . '" -o:"../asce_content/book/'.$isbn["isbn"].'/'.$bokvolno["volumeno"].'/commentary/' . $final_html .'" -xsl:"../asce_content/tool/src/xsl/jats-html.xsl"');
			
			
		}
       exit;
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
			$this->load->pagetemplate('uploadbooks_sucess',array('error' => ' ' ));
		}
			
			}
		}
	}
}
}
?>