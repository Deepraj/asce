<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/***
 * XML library for CodeIgniter
 *
 *    author: Woody Gilk
 * copyright: (c) 2006
 *   license: http://creativecommons.org/licenses/by-sa/2.5/
 *      file: libraries/Xml.php
 */
//error_reporting(E_ALL);
//ini_set('display_errors', 1); 
class Xml {
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
  public function get_xml_data (){
 return $this->parse_data;   
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