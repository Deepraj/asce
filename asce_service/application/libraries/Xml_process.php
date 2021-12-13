<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/***
 * XML library for CodeIgniter
 *
 *    author: Woody Gilk
 * copyright: (c) 2006
 *   license: http://creativecommons.org/licenses/by-sa/2.5/
 *      file: libraries/Xml.php
 */
class Xml_process {
  function Xml () {
  }
  private $document;
  private $filename;
  private $parse_data;
  public function load ($file) {
    /***
     * @public
     * Load an file for parsing
     */
    $bad  = array('|//+|', '|\.\./|');
    $good = array('/', '');
    $file = BASEPATH.preg_replace ($bad, $good, $file).'.xml';
	if (! file_exists ($file)) {
      return false;
    }
    $this->document = utf8_encode (file_get_contents($file));
	//echo ($this->document);
    $this->filename = $file;
    return true;
  }  /* END load */
  public function parse () {
    /***
     * @public
     * Parse an XML document into an array
     */
    $xml = $this->document;
    if ($xml == '') {
      return false;
    }
    $doc = new DOMDocument ();
    $doc->preserveWhiteSpace = false;
    if ($doc->loadXML ($xml)) {
		$this->parse_data = $doc;
    }
    return false;
  } /* END parse */
  
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

	  $arr_chapter = array();
	  $arrchap_return = array();
	  $chapter_titles = $this->parse_data->getElementsByTagName('title-group');
	  $k=0;
	  
foreach ($chapter_titles as $chapter_title) //go to each section 1 by 1 
		{
		 $label = $chapter_title->getElementsByTagName('label')->item(0)->nodeValue;
		 $title = $chapter_title->getElementsByTagName('title')->item(0)->nodeValue;
		 
		 $arr_chapter["label"] = $label;
		 $arr_chapter["title"] = $title;
		 $arrchap_return[] = $arr_chapter;
		 $k++;
		}
		return $arrchap_return;

}

/*public function get_fm_details(){

	  $arr_fm = array();
	  $arrs_fm_return = array();
	  $fm_titles = $this->parse_data->getElementsByTagName('body');
	  $k=0;
	  
foreach ($fm_titles as $fm_title) //go to each section 1 by 1 
		{
		 $para = $fm_title->getElementsByTagName('p')->item(0)->nodeValue;

		 $arr_fm["p"] = $para;
		 $arr_fm_return[] = $arr_fm;
		
		}
		return $arr_fm_return;

}*/

 public function get_section_details(){
	  $arr_sec = array();
	  $arrsec_return = array();
	  $sec_titles = $this->parse_data->getElementsByTagName('sec');
	  $k=0;
	  
foreach ($sec_titles as $sec_title) //go to each section 1 by 1 
		{
		 $attr_sec = $sec_title->getAttribute('id');   //get section attribute 
		 $title = $sec_title->getElementsByTagName('title')->item(0)->nodeValue;
		 $label = $sec_title->getElementsByTagName('label')->item(0)->nodeValue;
		 $para = $sec_title->getElementsByTagName('p')->item(0)->nodeValue;
		
		 $arr_sec["id"] = $attr_sec;
		 $arr_sec["title"] = $title;
		 $arr_sec["p"] = $para;
		 $arr_sec["label"] = $label;
		 $arrsec_return[] = $arr_sec;
		
		}
		return $arrsec_return;
}
  
  
  private function flatten_node ($node) {
    /***
     * @private
     * Helper function to flatten an XML document into an array
     */
    $array = array();
	
	$cahp_titles = $node->getElementsByTagName('title-group');
	foreach( $cahp_titles as $chap_title){
		$title = $chap_title->getElementsByTagName('title')->item(0)->nodeValue;
		$label = $chap_title->getElementsByTagName('label')->item(0)->nodeValue;
		echo $title ."==".$label;
	}	
 /*   foreach ($node->childNodes as $child) {
	    foreach ($child->childNodes as $book) {
			if($book->nodeName == "book-body"){
				echo $book->nodeName->childNodes['title-group'];
			}
		}
	}
	die();*/
    foreach ($node->childNodes as $child) {
      if ($child->hasChildNodes ()) {
		  
		  if ($node->firstChild->nodeName == $node->lastChild->nodeName && $node->childNodes->length > 1) {
          $array[$child->nodeName][] = $this->flatten_node ($child);
        }
        else {
          $array[$child->nodeName][] = $this->flatten_node($child);
          if ($child->hasAttributes ()) {
            $index = count($array[$child->nodeName])-1;
            $attrs =& $array[$child->nodeName][$index]['__attrs'];
            foreach ($child->attributes as $attribute) {
              $attrs[$attribute->name] = $attribute->value;
            }
          }
        }
      }
      else {
        return $child->nodeValue;
      }
    }
    return $array;
  } /* END node_to_array */
}
/* End of file Xml.php */
/* Location: ./application/libraries/Xml.php */